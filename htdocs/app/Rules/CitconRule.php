<?php

namespace App\Rules;


/**
 * Id必须是正整数验证
 * Class CodeInfoRule
 * @package App\Rules
 */
class CitconRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'vendor' => 'required|in:alipay,wechatpay',
        'callback_url' => 'required',
        'reference' => 'required'

    ];
    //失败信息
    protected $message = [

        'vendor.required' => '支付类型不能为空',
        'vendor.in' => '支付类型不在指定中',
        'callback_url.required' => '支付跳转url不能为空',
        'reference.required' => '订单单号不能为空'

    ];


}
