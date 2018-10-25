<?php

namespace App\Rules;


/**
 * Id必须是正整数验证
 * Class CodeInfoRule
 * @package App\Rules
 */
class EnterRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'operator' => 'required|max:100',
        'remark' => 'required|max:500'
    ];
    //失败信息
    protected $message = [
        'operator.required' => '操作人不能为空',
        'operator.max' => '操作人不能超过100个字符',
        'remark.required' => '备注不能为空',
        'remark.max' => '备注不能超过500个字符'
    ];


}
