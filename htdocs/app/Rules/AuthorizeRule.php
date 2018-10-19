<?php

namespace App\Rules;


/**
 * Id必须是正整数验证
 * Class CodeInfoRule
 * @package App\Rules
 */
class
AuthorizeRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'id' => 'required|positive_integer',
        'card' => 'required|positive_integer',
        'money' => 'required|numeric',
        'order' => 'required',
        'date' => 'required|date_format:m/y',
//        'status' => 'required|in:1,2',
        'code' => 'required',
//        'cancelUrl' => 'required',
//        'successUrl' => 'required'
    ];
    //失败信息
    protected $message = [
        'id.required' => '用户id不能为空',
        'id.positive_integer' => '用户id格式不正确',
        'card.required' => '卡号不能为空',
        'card.positive_integer' => '卡号格式不正确',
        'money.required' => '金额不能为空',
        'money.numeric' => '金额格式不正确',
        'order.required' => '订单号不能为空',
        'date.required' => 'EXP.DATE不能为空',
        'date.date_format' => 'EXP.DATE格式不正确',
//        'status.required' => '状态不能为空',
//        'status.in' => '状态不在指定值',
        'code.required' => '卡code不能为空',
        'code.positive_integer' => '卡code格式不正确',
//        'cancelUrl.required' => '返回路由不能为空',
//        'successUrl.required' => '成功路由不能为空',

    ];


}
