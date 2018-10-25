<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderProductModel extends Model
{
    protected $table = 'purchase_order_product';

    protected $guarded = [];


    public function products ()
    {
    	return $this->belongsTo('App\Http\Model\ProductModel', 'product_id', 'id');
    }

    public function distributor ()
    {
    	return $this->belongsTo('App\Http\Model\distributorModel', 'product_id', 'id');
    }



}
