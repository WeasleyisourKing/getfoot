<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ShelvesModel extends Model
{
    protected $table = 'shelves';

    protected $guarded = [];

    //关联商品和分类关系 一对多
    public function product ()
    {

        return $this->hasMany('App\Http\Model\ProductModel', 'brand_id', 'id');
    }
    // 多对多
    public function goods()
    {

        return $this->belongsToMany('App\Http\Model\ProductModel', 'product_shelves',
            'shelves_id', 'product_id');

    }


    //获取品牌列表
    public static function getBrandList ($status, $limit)
    {


        return self::where('id', '!=', 1)
            ->whereIn('status', $status)
            ->orderBy('created_at', 'desc')
            ->paginate($limit);
    }

    //根据id获取信息
    public static function getBrandId ($id)
    {

        return self::where('id', '=', $id)
            ->first();

    }
    public static function updateShelveInfo ($shelves,$productId) {


        DB::beginTransaction();
        try {

                ProductShelvesModel::whereIn('product_id', $productId)->delete();

                $she = [];

                foreach ($shelves as $ps) {
                    foreach ($ps['data'] as $pso) {
                        array_push($she, ['product_id' => $ps['id'], 'shelves_id' => $pso['shelves_id']]);
                    }
                }

                (new ProductShelvesModel)->insert($she);

            DB::commit();
        }catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }
    }

    //修改品牌
    public static function updateBrandInfo ($id, $data,$shelves,$productId)
    {

        DB::beginTransaction();
        try {
            self::where('id', '=', $id)->update($data);

        if (!is_null($shelves)) {
            ProductShelvesModel::whereIn('product_id', $productId)->delete();

            $she = [];

            foreach ($shelves as $ps) {
                foreach ($ps['data'] as $pso) {
                    array_push($she, ['product_id' => $ps['id'], 'shelves_id' => $pso['shelves_id']]);
                }
            }

            (new ProductShelvesModel)->insert($she);
        }
            DB::commit();


        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }
    }

    //插入新的品牌
    public static function insertBrand ($data)
    {
        return (new self($data))->save();

    }

    //品牌名唯一
    public static function uniqueBrand ($name)
    {
        return self::where('name', '=', $name)->first();

    }

    //品牌名唯一
    public static function unique ($id,$name)
    {
        return self::where('name', '=', $name)
            ->where('id','!=',$id)
            ->first();

    }
    //获取全部显示品牌
    public static function getBrandAll ($status)
    {

        return self::where('status', '=', $status)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    //删除分类
    public static function delBrand ($id)
    {
        self::where('id', '=', $id)
            ->delete();

//        //涉及多表 使用事务控制
//        DB::beginTransaction();
//        try {
//
//            self::where('id', '=', $id)
//                ->delete();
//
//            (new ProductModel)->where('brand_id', '=', $id)->update([
//                'brand_id' => 1
//            ]);
//
//            DB::commit();
//
//        } catch (\Exception $ex) {
//            DB::rollBack();
//            //记录日志
//            throw $ex;
//        }

    }
}


