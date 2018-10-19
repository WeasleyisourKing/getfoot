<?php

namespace App\Rules;


/**
 * 用户注册验证
 * Class CodeInfoRule
 * @package App\Rules
 */
class RegisterRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'name' => 'required|max:30',
        'sex' => 'required|in:1,2',
        'email' => 'required|email',
        'password' => 'required'
    ];
    //失败信息
    protected $message = [
        'name.required' => '名字不能为空',
        'name.max' => '名字超过最大限制30字',
        'sex.required' => '性别不能为空',
        'sex.in' => '性别参数不正确',
        'email.required' => '邮箱不能为空',
        'email.email' => '邮箱格式不正确',
        'password.required' => '密码不能为空'
    ];


}
