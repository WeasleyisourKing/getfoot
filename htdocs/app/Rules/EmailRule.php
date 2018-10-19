<?php

namespace App\Rules;


/**
 * Id必须是正整数验证
 * Class CodeInfoRule
 * @package App\Rules
 */
class EmailRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'email' => 'required|email'
    ];
    //失败信息
    protected $message = [
        'email.required' => '邮箱不能为空',
        'email.email' => '邮箱格式不正确'
    ];


}
