<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class PrivilegeModel extends Model
{
    protected $table = 'privilege';

    protected $guarded = [];


    public function role ()
    {
    	return $this->hasMany('App\Http\Model\ProductModel', 'id', 'product_id');
    }
    public function privilege ()
    {
        return $this->hasMany('App\Http\Model\PrivilegeRoleModel', 'role_id', 'id');
    }
//    public function distributor ()
//    {
//    	return $this->belongsTo('App\Http\Model\distributorModel', 'product_id', 'id');
//    }


}
