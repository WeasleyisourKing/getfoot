<?php

namespace App\Rules;


/**
 * Id必须是正整数验证
 * Class CodeInfoRule
 * @package App\Rules
 */
class StockRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'data' => 'check_stock'
    ];
    //失败信息
    protected $message = [

        'data.check_stock' => '参数类型或者格式不正确'
    ];


}
