<?php

namespace App\Rules;


/**
 * 用户是否是新用户接口验证
 * Class CodeInfoRule
 * @package App\Rules
 */
class CodeInfoRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'code' => 'required'

    ];
    //失败信息
    protected $message = [
        'code.required' => 'code不能为空',
    ];


}
