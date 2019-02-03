<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CategoryModel extends Model
{
    protected $table = 'category';

    protected $guarded = [];


    //精品 多对多
    public function hot ()
    {

        return $this->belongsToMany('App\Http\Model\ProductModel', 'fine_product',
             'category_id', 'product_id');

    }
    //嵌套关联image表 一对一 横幅和图片
//    public function img ()
//    {
//        return $this->belongsTo('App\Http\Model\ImageModel', 'image_id', 'id');
//    }

    //关联商品和分类关系 一对多
    public function product ()
    {

        return $this->hasMany('App\Http\Model\ProductModel', 'category_id', 'id');
    }


//获取二级分类下商品
    public static function getTwoCategory ()
    {
        return CategoryModel::with(['product' => function ($query) {
            $query->with('distributor')
                ->select('zn_name','en_name',
                    'id', 'category_id', 'brand_id', 'product_image', 'stock','frozen_stock')
                ->where('status', '=', 1)
                ->orderBy('stock', 'desc')
                ->with('brand');
        }])
            ->where('id', '!=', 1)
            ->where('status', '=', 1)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }


    //获取所有二级分类
    public static function getCategorysList ()
    {
        $data = self::where('pid', '=', 0)
            ->where('id', '!=', 1)
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        $a = [];
        foreach ($data as $val) {
            $id = $val['id'];
            $a[] = self::where('pid', '=', $id)->get();
        }
        return $a;
    }

    //获取分类列表
    public static function getCategoryList ($limit)
    {

        return self::where('id', '!=', 1)
            ->where('status', 1)
            ->where('pid', '=', 0)
            ->orderBy('created_at', 'desc')
            ->paginate($limit);
    }

    //获取二级分类列表
    public static function getCategoryLevel ($id, $status, $limit)
    {

        return self::where('pid', '=', $id)
            ->whereIn('status', $status)
            ->orderBy('score', 'asc')
            ->paginate($limit);
    }

    //根据id获取信息
    public static function getCategoryId ($id)
    {

        return self::where('id', '=', $id)
            ->first();

    }

    //修改分类
    public static function updateCategoryInfo ($id, $data)
    {
        return self::where('id', '=', $id)->update($data);
    }

    //插入新的类
    public static function insertCategory ($data)
    {
        return (new self($data))->save();

    }

    //类名唯一
    public static function uniqueCategory ($name)
    {
        return self::where('zn_name', '=', $name)
            ->where('pid', '=', 0)
            ->first();

    }

    //类名唯一
    public static function unique ($id, $name)
    {
        return self::where('zn_name', '=', $name)
            ->where('pid', '=', 0)
            ->where('id', '!=', $id)
            ->first();

    }

    //类名唯一
    public static function uniqueCategoryLevel ($id, $name)
    {
        return self::where('zn_name', '=', $name)
            ->where('pid', '=', $id)
            ->first();

    }

    //类名唯一
    public static function uniqueLevel ($pid, $id, $name)
    {
        return self::where('zn_name', '=', $name)
            ->where('pid', '=', $pid)
            ->where('id', '!=', $id)
            ->first();

    }

    //获取全部显示分类
    public static function getCategoryAll ($status)
    {

        return self::where('status', '=', $status)
            ->orderBy('created_at', 'desc')
            ->get();

    }

    //删除分类
    public static function delCategory ($id)
    {

        //涉及多表 使用事务控制
        DB::beginTransaction();
        try {

            self::where('id', '=', $id)
                ->delete();

            (new ProductModel)->where('category_id', '=', $id)->update([
                'category_id' => 1
            ]);

            DB::commit();

        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }

    }

    //首页数据
    public static function getHomePage ()
    {
        return self::with(['product' => function ($query) {
            $query->select('zn_name','en_name',
                'id', 'product_image', 'category_id', 'stock','frozen_stock')
                ->where('status', '=', 1)
                ->orderBy('stock', 'desc')
                ->with('distributor');
        }])
            ->select('id', 'zn_name', 'en_name', 'pid', 'icon')
            ->where('status', '=', 1)
            ->where('id', '!=', 1)
            ->orderBy('created_at', 'desc')
            ->get();

    }

    //根据id获取二级分类下的所有商品
    public static function getTwoLevel ($id)
    {
        return self::with(['product' => function ($query) {

            $query->select('zn_name','en_name',
                'id', 'product_image', 'stock', 'category_id', 'brand_id','frozen_stock')
                ->where('status', '=', 1)
                ->orderBy('stock', 'desc')
                ->with(['brand', 'distributor']);
        }])
            ->where('id', '=', $id)
            ->where('status', '=', 1)
            ->get();
    }

    //修改商品库存
    public static function updateScoreCategory ($data)
    {

        DB::beginTransaction();
        try {

            foreach ($data as $v) {

                $flight = self::find($v['id']);
                $flight->score = $v['score'];
                $flight->save();

            }


            DB::commit();

        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }
    }
}
