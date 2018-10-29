<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class AdminRoleModel extends Model
{
    protected $table = 'admin_role';

    //黑名单
    protected $guarded = [];


    //关联主题和商品关系 多对多
    public function auth ()
    {

        return $this->belongsToMany('App\Http\Model\PrivilegeModel', 'privilege_role',
            'role_id','privilege_id' );

    }
    //获取管理员角色
    public static function getRole($limit) {

        return self::with('auth')->orderBy('created_at', 'desc')
            ->paginate($limit);
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

    //插入新的角色
    public static function insertRole ($data)
    {

        return (new self($data))->save();

    }
    //修改角色
    public static function updateUsersRole ($id, $data)
    {
        return self::where('id', '=', $id)->update($data);
    }

    //获取管理员角色
    public static function getList($limit) {

        return self::orderBy('created_at', 'desc')
            ->paginate($limit);
    }

}
