<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class FineProductModel extends Model
{
    protected $table = 'fine_product';

    protected $guarded = [];

    //关联主题区和图片关系 一对一
    public function cat ()
    {

        return $this->belongsTo('App\Http\Model\CategoryModel', 'category_id', 'id');
    }


}
