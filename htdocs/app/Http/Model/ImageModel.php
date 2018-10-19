<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class ImageModel extends Model
{
    protected $table = 'image';

    protected $fillable = ['url', 'from'];

    //插入上传图片
    public static function insertImage ($data)
    {

        $obj = new self($data);
        $obj->save();
        return $obj;
    }
}
