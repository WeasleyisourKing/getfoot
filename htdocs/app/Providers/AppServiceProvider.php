<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot ()
    {
        //自定义验证码规则
        //是否是正整数
        Validator::extend('positive_integer', function ($attribute, $value, $parameters) {
            if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
                return true;
            }
            return false;
        });

        //数值0-100
        Validator::extend('positive', function ($attribute, $value, $parameters) {
            if (is_numeric($value) && $value >= 0 && $value <= 100) {
                return true;
            }
            return false;
        });

        //金额格式数值验证 最大百万
        Validator::extend('price_value', function ($attribute, $value, $parameters) {
            if (!empty($value) && ((is_numeric($value) && ($value + 0) > 0)) && ((strstr($value, '.')) == false || strlen(strstr($value, '.')) <= 3)) {
                if ($value <= 999999.99) {
                    return true;
                }
            }
            return false;
        });

        //验证商品参数
        Validator::extend('check_products', function ($attribute, $value, $parameters) {


            $value = !is_array($value) ? json_decode($value, true) : $value;


            if (!is_array($value)) {
                return false;
            }

            $comple = ['product_id', 'count'];

            if (count($value) == count($value, 1)) {
                foreach ($value as $k => $v) {
                    //是否是指定字段
                    if (!in_array($k, $comple)) {
                        return false;
                    }
                    //是否是正整数
                    if (!is_numeric($v) || !is_int($v + 0) || !($v + 0 > 0)) {

                        return false;
                    }

                }

            } else {
                foreach ($value as $k => $v) {
                    foreach ($v as $key => $val) {
                        //是否是指定字段
                        if (!in_array($key, $comple)) {
                            return false;
                        }
                        //是否是正整数
                        if (!is_numeric($val) || !is_int($val + 0) || !($val + 0 > 0)) {
                            return false;
                        }

                    }
                }
            }
            return true;
        });

        //验证库存商品参数
        Validator::extend('check_stock', function ($attribute, $value, $parameters) {

            if (!is_array($value)) {
                return false;
            }

            $comple = ['product_id', 'count'];
            foreach ($value as $k => $v) {
                foreach ($v as $key => $val) {
                    //是否是指定字段
                    if (!in_array($key, $comple)) {
                        return false;
                    }

                    //是否是整数
                    if (!is_numeric($val) ) {
                        return false;
                    }
                    if ($val > 999999) {
                        return false;
                    }

                }
            }

            return true;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register ()
    {
        //
    }
}
