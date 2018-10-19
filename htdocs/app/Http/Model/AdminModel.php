<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;


class AdminModel extends Model
{
    protected $table = 'admin';

    protected $hidden = [];

    protected $guarded = [];


    //一对多 用户和地址
    public function manys ()
    {
        return $this->hasOne('App\Http\Model\AdminRoleModel', 'id', 'role');
    }

    //获取管理员列表 根据status
    public static function getList ( $status,$limit)
    {
        return self::with('manys')
            ->whereIn('status', $status)
            ->orderBy('created_at', 'desc')
            ->paginate($limit);
    }

    //获取管理员列表 根据status
    public static function getLists ($type,$status,$limit)
    {
        return self::where('role', '=',$type)
            ->whereIn('status', $status)
            ->orderBy('created_at', 'desc')
            ->paginate($limit);
    }

    //写入最后登录ip 登录时间
    public static function updateIpAndLoginTime ($id, $data)
    {
        return self::where('id', '=', $id)->update($data);
    }

    //修改基本信息
    public static function updateAdminInfo ($id, $data)
    {
        return self::where('id', '=', $id)->update($data);
    }

    //添加管理员
    public static function insertAdminInfo ($data)
    {
        return (new self($data))->save();

    }

    //修改密码
    public static function modifyAdmin ($psd)
    {

        return self::where('id', '=', 1)->update(['password'=>$psd]);

    }

    //搜索框搜索
    public static function getSearch ($value)
    {

        return self::where('username', 'like', $value . '%')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    //删除角色
    public static function delAdmin ($id)
    {
        return self::where('id', '=', $id)
            ->delete();

    }

}
