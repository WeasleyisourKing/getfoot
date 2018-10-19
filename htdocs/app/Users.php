<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable
{
    protected $fillable = ['name','password'];

    protected $table = 'users';  //定义用户表名称

//    public $timestamps = false;
}
