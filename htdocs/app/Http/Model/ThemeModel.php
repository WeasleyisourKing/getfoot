<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ThemeModel extends Model
{
    protected $table = 'theme';

    protected $guarded = [];

    //关联主题区和图片关系 一对一
    public function themeImg ()
    {

        return $this->belongsTo('App\Http\Model\ImageModel', 'theme_image_id', 'id');
    }


    //关联特定主题列表和图片关系 一对一
//    public function headImg ()
//    {
//
//        return $this->belongsTo('App\Http\Model\ImageModel', 'head_image_id', 'id');
//    }

    //关联主题和商品关系 多对多
    public function products ()
    {

        return $this->belongsToMany('App\Http\Model\ProductModel', 'theme_product',
            'theme_id', 'product_id');

    }

    //获取首页数据
    public static function getHomePageList ()
    {

        $first = self::whereIn('id', [1, 2]);

        return self::with(['products' => function ($query) {
            $query->with('distributor');
        }])
            ->union($first)
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

    }

    //获取活动列表
    public static function getThemeList ($type)
    {

        return self::orderBy('created_at', 'desc')
            ->where('type', '=', $type)
            ->get();
    }

    //活动是否唯一
    public static function ArticleUnique ($title)
    {
        return self::where('zn_name', '=', $title)
            ->first();
    }

    //添加活动
    public static function insertArticleInfo ($data)
    {

        return (new self($data))->save();
    }

    //修改活动
    public static function updateArticle ($id, $data)
    {
        return self::where('id', '=', $id)->update($data);
    }


    //删除活动
    public static function delArticle ($id)
    {
        DB::beginTransaction();

        try {
            self::where('id', '=', $id)
                ->delete();

            (new ThemeProductModel)->where('theme_id', '=', $id)
                ->delete();

            DB::commit();

        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }

    }

    //添加商品活动,添加一新参数，判断theme是否为空即theme_id=0
    public static function addArticleproduct ($id, $data, $theme_null, $status)
    {

        DB::beginTransaction();
        try {

            ThemeProductModel::where('product_id', '=', $id)->delete();
//            FineProductModel::where('product_id', '=', $id)->delete();
            if ($theme_null != ['0']) {

                ThemeProductModel::insert($data);
                //如果精品推荐
                if ($status != -1) {
                    FineProductModel::where('product_id', '=', $id)->delete();
                    foreach ($data as $items) {
                        if ($items['theme_id'] == 3) {

                            FineProductModel::insert([
                                'category_id' => $status,
                                'product_id' => $items['product_id']
                            ]);
                        }
                    }
                }


            }

            DB::commit();

        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }

    }

    //获取首页数据
    public static function getPcHomePage ()
    {

        return self::with(['products' => function ($query) {

            $query->select(
                DB::raw("CASE stock - frozen_stock WHEN 0 THEN CONCAT('【已售罄】',zn_name) ELSE zn_name END as 'zn_name',
                CASE stock - frozen_stock WHEN 0 THEN CONCAT('【Sold out】',en_name) ELSE en_name END as 'en_name'"),
                'id', 'product_image', 'stock','frozen_stock')
                ->where('status', '=', 1)
                ->with('distributor');
        }])
            ->whereIn('id', [1, 2])
            ->orderBy('created_at', 'desc')
            ->get();

    }
}
