<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class UsersDiscountModel extends Model
{
    protected $table = 'users_discount';

    protected $guarded = [];

    public $timestamps = false;

    //关联折扣码和信息关系 一对一
    public function discount ()
    {

        return $this->belongsTo('App\Http\Model\DiscountModel', 'discount_id', 'id');
    }

    //关联折扣码和信息关系 一对一
    public function order ()
    {

        return $this->belongsTo('App\Http\Model\OrderModel', 'id', 'discount_id');
    }
}
