<?php

namespace App\Rules;


/**
 * 修改密码验证
 * Class CodeInfoRule
 * @package App\Rules
 */
class PasswordRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'oldPasswd' => 'required',
        'newPasswd' => 'required'
    ];
    //失败信息
    protected $message = [
        'oldPasswd.required' => '原始密码不能为空',
        'newPasswd.required' => '新密码不能为空',
    ];


}
