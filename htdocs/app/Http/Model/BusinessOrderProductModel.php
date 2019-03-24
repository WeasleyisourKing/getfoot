<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class BusinessOrderProductModel extends Model
{
    protected $table = 'business_order_product';

    protected $guarded = [];


    public static function orderProduct ($id)
    {
        return $data = BusinessOrderProductModel::with(['products'=>function($query){
            $query->with('distributor');
        }])
            ->select('product_id','count')
            ->where('order_id','=',$id)
            ->get();
    }

    public function business ()
    {
        return $this->hasMany('App\Http\Model\BusinessOrderModel', 'id', 'order_id');
    }

    public function products ()
    {
        return $this->belongsTo('App\Http\Model\ProductModel', 'product_id', 'id');
    }
    public function distributor ()
    {
    	return $this->belongsTo('App\Http\Model\distributorModel', 'product_id', 'id');
    }


}
