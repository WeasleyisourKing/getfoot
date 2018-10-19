<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class UsersRoleModel extends Model
{
    protected $table = 'users_role';

    protected $guarded = [];

    //获取用户角色
    public static function getRole($limit) {

        return self::orderBy('created_at', 'desc')
            ->paginate($limit);
    }

    //修改角色
    public static function updateUsersRole ($id, $data)
    {
        return self::where('id', '=', $id)->update($data);
    }

    //插入新的角色
    public static function insertRole ($data)
    {

        return (new self($data))->save();

    }

    //检测角色是否存在
    public static function roleIsExist ($name)
    {

        return self::where('name','=',$name)->first();

    }

    //删除角色
    public static function delRole ($id)
    {
        return self::where('id', '=', $id)
            ->delete();

    }

}
