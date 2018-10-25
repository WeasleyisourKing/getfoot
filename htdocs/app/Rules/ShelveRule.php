<?php

namespace App\Rules;


/**
 * Id必须是正整数验证
 * Class CodeInfoRule
 * @package App\Rules
 */
class ShelveRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'id' => 'required|positive_integer',
        'number' => 'required',
        'status' => 'required|in:1,2'
    ];
    //失败信息
    protected $message = [
        'id.required' => 'id不能为空',
        'id.positive_integer' => '用户id不是正整数',
        'number.required' => '货架编号不能为空',
          'status.required' => '货架状态不能为空',
        'status.in' => '货架状态不在指定值'
    ];


}
