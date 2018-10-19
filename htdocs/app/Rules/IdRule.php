<?php

namespace App\Rules;


/**
 * Id必须是正整数验证
 * Class CodeInfoRule
 * @package App\Rules
 */
class IdRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'id' => 'required|positive_integer'
    ];
    //失败信息
    protected $message = [
        'id.required' => 'id不能为空',
        'id.positive_integer' => 'id不是正整数'
    ];


}
