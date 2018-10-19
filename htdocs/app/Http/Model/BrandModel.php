<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BrandModel extends Model
{
    protected $table = 'brand';

    protected $guarded = [];


    //关联商品和分类关系 一对多
    public function product ()
    {

        return $this->hasMany('App\Http\Model\ProductModel', 'brand_id', 'id');
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

    //修改品牌
    public static function updateBrandInfo ($id, $data)
    {
        return self::where('id', '=', $id)->update($data);
    }

    //插入新的品牌
    public static function insertBrand ($data)
    {
        return (new self($data))->save();

    }

    //品牌名唯一
    public static function uniqueBrand ($name)
    {
        return self::where('zn_name', '=', $name)->first();

    }

    //品牌名唯一
    public static function unique ($id,$name)
    {
        return self::where('zn_name', '=', $name)
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

        //涉及多表 使用事务控制
        DB::beginTransaction();
        try {

            self::where('id', '=', $id)
                ->delete();

            (new ProductModel)->where('brand_id', '=', $id)->update([
                'brand_id' => 1
            ]);

            DB::commit();

        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }

    }
}
