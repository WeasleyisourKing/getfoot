<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class PrivilegeRoleModel extends Model
{
    protected $table = 'privilege_role';

    protected $guarded = [];


//    public function privilege ()
//    {
//    	return $this->hasMany('App\Http\Model\PrivilegeModel',  'id','privilege_id');
//    }
//
//    public function distributor ()
//    {
//    	return $this->belongsTo('App\Http\Model\distributorModel', 'product_id', 'id');
//    }


}
