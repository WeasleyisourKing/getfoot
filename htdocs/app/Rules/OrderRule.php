<?php

namespace App\Rules;


/**
 * 订单验证
 * Class CodeInfoRule
 * @package App\Rules
 */
class OrderRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'products' => 'required|check_products'
    ];
    //失败信息
    protected $message = [
        'products.required' => '商品参数不能为空',
        'products.check_products' => '商品参数不合法'

    ];


}
