<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class PalletProductModel extends Model
{
    protected $table = 'pallet_product';

    protected $guarded = [];

    //关联商品和分销商关系 一对一
    public function name ()
    {
        return $this->belongsTo('App\Http\Model\PalletModel', 'pallet_id','id');
    }
    public function product ()
    {
        return $this->belongsTo('App\Http\Model\ProductModel', 'product_id','id');
    }
}
