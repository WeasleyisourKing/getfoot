<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class StockOrderProductModel extends Model
{
    protected $table = 'stock_order_product';

    protected $guarded = [];


    public function products ()
    {
    	return $this->belongsTo('App\Http\Model\ProductModel', 'product_id', 'id');
    }

    public function distributor ()
    {
    	return $this->belongsTo('App\Http\Model\distributorModel', 'product_id', 'id');
    }

    //关联商品和品牌关系 一对一
    public function info ()
    {
        return $this->belongsTo('App\Http\Model\StockOrderModel', 'order_id', 'id');
    }


}
