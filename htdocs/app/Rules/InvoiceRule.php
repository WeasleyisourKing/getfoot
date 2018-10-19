<?php

namespace App\Rules;


/**
 * Id必须是正整数验证
 * Class CodeInfoRule
 * @package App\Rules
 */
class InvoiceRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'userId' => 'required|positive_integer',
        'orderId' => 'required',
        'status' => 'required|in:1,2'
    ];
    //失败信息
    protected $message = [
        'userId.required' => 'id不能为空',
        'userId.positive_integer' => 'id不是正整数',
        'orderId.required' => '订单号不能为空',
        'status.required' => '状态不能为空',
        'status.in' => '状态不在指定值'
    ];


}
