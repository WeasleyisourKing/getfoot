<?php

namespace App\Rules;


/**
 * 用户角色验证
 * Class CodeInfoRule
 * @package App\Rules
 */
class IdAndRoleRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'id' => 'required|positive_integer',
        'name' => 'required|max:20'
    ];
    //失败信息
    protected $message = [
        'id.required' => 'id不能为空',
        'id.positive_integer' => '用户id不是正整数',
        'name.required' => '名字不能为空',
        'name.max' => '名字不能超过20个字',
    ];


}
