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
    		$query->with(['distributor'=>function($query){
    			$query->select('product_id','level_four_price');
    		}]);
    	}])
    	->select('product_id','count')
    	->where('order_id','=',$id)
    	->get();
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
