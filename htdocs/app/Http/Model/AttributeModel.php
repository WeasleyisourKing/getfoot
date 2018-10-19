<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AttributeModel extends Model
{
    protected $table = 'attribute';

    protected $guarded = [];

    //获取某些商品信息
    public static function getAttr ($status)
    {

        return self::where('status', '=', $status)
            ->get();

    }


}
