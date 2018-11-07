<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\OrderModel;
use App\Http\Model\GeneralModel;
use App\Http\Controllers\Common;
use App\Rules\FreightRule;
use App\Exceptions\ParamsException;

/**
 * 仪表盘管理类
 * Class ManagerController
 * @package App\Http\Controllers\Admin
 */
class DashboardController extends Controller
{

    /**
     * 仪表盘首页页面
     * @param Request $request
     * @return null
     */
    public function index ()
    {

        if (is_null(Auth()->user())) {

            return redirect('/login');
        }

        return view('admin.dashboard.index');

    }

}

