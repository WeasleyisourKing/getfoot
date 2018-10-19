<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Common;
use Illuminate\Database\QueryException;

class DiscountModel extends Model
{
    protected $table = 'discount';

    protected $guarded = [];


    //关联商品和分类关系 一对多
    public function info ()
    {

        return $this->hasMany('App\Http\Model\UsersDiscountModel', 'discount_id', 'id');
    }


    //名唯一
    public static function unique ($name)
    {
        return self::where('zn_name', '=', $name)
            ->first();

    }

    //折扣码名唯一
    public static function uniqueDiscount ($id, $name)
    {
        return self::where('zn_name', '=', $name)
            ->where('id', '!=', $id)
            ->first();

    }

    //插入新的折扣码
    public static function insertDiscount ($data, $stock)
    {


        //涉及多表 使用事务控制
        DB::beginTransaction();
        try {

            $obj = new self($data);
            $obj->save();

            for($i = 0; $i < $stock; $i++) {

                (new UsersDiscountModel)->insert(['discount_id' => $obj->id,'code' => $data['code']]);
            }

            DB::commit();

        } catch (\Exception $ex) {

            //随机会有重复的 解决办法监听错误 重新生成
            DB::rollBack();
//            if ($ex instanceof QueryException ) {
//
//                self::insertDiscount($data,$stock);
//            } else {
//                //记录日志
//                throw $ex;
//            }

            throw $ex;

        }


    }

    //删除折扣码
    public static function delDiscount ($id)
    {

        //涉及多表 使用事务控制
        DB::beginTransaction();
        try {

            self::where('id', '=', $id)
                ->delete();

            (new UsersDiscountModel)->where('discount_id', '=', $id)->delete();

            DB::commit();

        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }

    }

    //修改折扣码
    public static function updateDiscount ($id, $data)
    {
        return self::where('id', '=', $id)->update($data);
    }

}
