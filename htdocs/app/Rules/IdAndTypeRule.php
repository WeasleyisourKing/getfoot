<?php

namespace App\Rules;


/**
 * Id必须是正整数验证
 * Class IdAndTypeRule
 * @package App\Rules
 */
class IdAndTypeRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'type' => 'required|in:1,2',
        'id' => 'required|positive_integer'
    ];
    //失败信息
    protected $message = [
        'id.required' => 'id不能为空',
        'id.positive_integer' => 'id不是正整数',
        'type.required' => '类型不能为空',
        'type.in' => '类型不在指定数值',

    ];


}
