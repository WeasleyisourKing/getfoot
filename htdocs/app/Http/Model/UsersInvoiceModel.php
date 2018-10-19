<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsersInvoiceModel extends Model
{
    protected $table = 'users_invoice';

    //黑名单
    protected $guarded = [];


    //查询用户地址
    public static function getUserAddress ($id)
    {
        return self::where('users_id', '=', $id)
            ->where('default', '=', 1)
            ->first();
    }

    //查询用户地址
    public static function insertData ($data)
    {
        return self::insert($data);
    }

    //名字唯一
    public static function unqiueName ($id, $name)
    {
        return self::where('users_id', '=', $id)->where('name', '=', $name)->first();
    }

    //获取用户地址
    public static function getIdInfo ($id)
    {
        return self::where('users_id', '=', $id)->get();
    }

    //修改用户地址
    public static function updateData ($id, $data)
    {
        DB::beginTransaction();
        try {
            $userId = self::select('users_id')->where('id', '=', $id)->first();

            self::where('users_id', '=', $userId->users_id)->update(['default' => 2]);

            self::where('id', '=', $id)->update($data);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            //记录日志
            throw $ex;
        }

    }

    //修改用户地址
    public static function updateDataAddress ($id, $data)
    {

        return self::where('users_id', '=', $id)->update($data);
    }

    //删除用户地址
    public static function delAddress ($id)
    {
        return self::where('id', '=', $id)->delete();
    }
}
