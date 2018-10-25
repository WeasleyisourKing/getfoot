<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsersModel extends Model
{
    protected $table = 'users';

    protected $hidden = [];


    protected $fillable = ['name', 'sex', 'password', 'email', 'avatar', 'integral', 'status', 'role', 'email_token'];//开启白名单字段


    //默认用户头像图片
    public function getAvatarAttribute ($value)
    {
        if (empty($value)) {
            return config('custom.DIRECTORY_SEPARATOR') . 'uploads' . config('custom.DIRECTORY_SEPARATOR') . config('custom.user_url');
        }
        return $value;
    }

    //获取用户列表
    public static function getUserList ($status, $limit)
    {

        return self::select('id', 'name', 'role', 'status',
            DB::raw("(CASE sex WHEN '1' THEN '男' WHEN '2' THEN '女' END) as sex"),
            'email', 'avatar', 'integral', 'created_at')
            ->whereIn('status', $status)
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

    }


    //多对多 从表 中间表 主表外键 从表外键
    //wherePivot 中间表where语句 wherePivotIn
    //as pivot 别名

    //一对多 用户和地址
    public function manys ()
    {
        return $this->hasMany('App\Http\Model\UsersAddressModel', 'users_id', 'id');
    }

    //一对多 用户和订单
    public function orederManys ()
    {
        return $this->hasMany('App\Http\Model\BusinessOrderModel', 'users_id', 'id');
    }

    //获取用户地址信息
    public static function getUserAddress ($id)
    {


        return self::with(['manys' => function ($query)  {

            $query->orderBy('created_at', 'desc');
        }])
            ->where('id', '=', $id)
            ->get()
            ->toArray();
    }

    //获取用户订单信息
    public static function getUserOrder ($id,$status = null)
    {

        if (!empty($status)) {

            return self::with(['orederManys' => function ($query) use ($status) {

                $query->where('status', '=', $status)->orderBy('created_at', 'desc');
            }])
                ->where('id', '=', $id)
                ->get()
                ->toArray();

        } else {
            return self::with(['orederManys' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }])
                ->where('id', '=', $id)
                ->get()
                ->toArray();
        }

    }


    //添加用户
    public static function getUserAdd ($data)
    {
        $obj = new self($data);
        $obj->save();
        return $obj;
    }

    //删除用户
    public static function delUser ($id)
    {
        return self::where('id', '=', $id)
            ->delete();

    }

    //修改用户
    public static function updateUserInfo ($id, $data)
    {
        return self::where('id', '=', $id)->update($data);
    }

    //根据id 获取用户信息
    public static function getUserInfo ($id)
    {
        return self::where('id', '=', $id)
            ->where('status', '=', 1)
            ->first();

    }

    //根据id 获取用户信息
    public static function emailunique ($email)
    {
        return self::where('email', '=', $email)
            ->first();

    }

    //根据id 获取用户信息
    public static function getUser ($data)
    {
        return self::where('email_token', '=', $data)
            ->first();

    }

}
