<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\OrderModel;
use App\Http\Model\GeneralModel;
use App\Http\Controllers\Common;

use App\Exceptions\ParamsException;

/**
 * 仪表盘管理类
 * Class ManagerController
 * @package App\Http\Controllers\Admin
 */
class StatisticController extends Controller
{

    //商品销售统计
    public function product ()
    {

        return view('admin.count.count-product');
    }

    //订单统计
    public function order ()
    {

        return view('admin.count.count-product');
    }

    //财务统计
    public function finance ()
    {

        return view('admin.count.count-product');
    }
    //用户统计
    public function user ()
    {

        return view('admin.count.count-product');
    }
}

