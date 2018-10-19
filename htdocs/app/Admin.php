<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable = ['username','password'];

    protected $table = 'admin';  //定义用户表名称

    public $timestamps = false;
}
