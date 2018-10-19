<?php

namespace App\Rules;


/**
 * 登录验证
 * Class CodeInfoRule
 * @package App\Rules
 */
class SignRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'email' => 'required|email',
        'password' => 'required',
    ];
    //失败信息
    protected $message = [
        'email.required' => '邮箱不能为空',
        'email.email' => '邮箱格式不对',
        'password.required' => '密码不能为空'
    ];


}
