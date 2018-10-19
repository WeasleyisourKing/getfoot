<?php

namespace App\Rules;


/**
 * 用户信息接口验证
 * Class UserInfoRule
 * @package App\Rules
 */
class UserInfoRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'name' => 'required|max:20',
        'sex' => 'required|in:1,2',
        'email' => 'required|email',
//        'integral' => 'required|positive_integer'
    ];
    //失败信息
    protected $message = [
        'name.required' => '用户名字不能为空',
        'name.max' => '用户名字不能超过20个字',
        'sex.required' => '性别不存在',
        'sex.in' => '性别不是指定字符',
        'email.required' => '邮箱不能为空',
        'email.email' => '邮箱格式不对',
//        'integral.required' => '积分不能为空',
//        'integral.positive_integer' => '积分不是正整数'
    ];


}
