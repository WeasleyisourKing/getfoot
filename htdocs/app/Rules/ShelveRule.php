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
        'shelves' => 'required|max:100'
    ];
    //失败信息
    protected $message = [
        'id.required' => 'id不能为空',
        'id.positive_integer' => '用户id不是正整数',
        'shelves.required' => '货架不能为空',
          'shelves.max' => '货架不能超过100个字'
    ];


}
