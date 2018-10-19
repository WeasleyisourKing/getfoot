<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class GeneralModel extends Model
{
    protected $table = 'general';

    public $timestamps = false;

    protected $guarded = [];

    //获取通用信息
    public static function getGeneral ($id)
    {
        return self::where('id', '=', $id)
            ->first();
    }

    //修改通用设置
    public static function updateGeneralInfo ($id, $data)
    {
        return self::where('id', '=', $id)->update($data);
    }


    //修改邮费设置
    public static function updateFreightInfo ($data)
    {
        return self::where('id', '=', 1)->update($data);
    }
}
