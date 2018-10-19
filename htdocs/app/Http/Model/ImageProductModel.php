<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class ImageProductModel extends Model
{
    protected $table = 'image_product';

    protected $guarded = [];

    public static function getProductImage ($id)
    {

       return self::select('link')
            ->where('product_id', '=',$id)
            ->get();
    }
}
