<?php

namespace App\Rules;


/**
 * Id必须是正整数验证
 * Class CodeInfoRule
 * @package App\Rules
 */
class ActivityRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'id' => 'required|positive_integer',
        'zn_name' => 'required|max:50',
        'en_name' => 'required|max:60'
    ];
    //失败信息
    protected $message = [
        'id.required' => 'id不能为空',
        'zn_name.max' => '活动中文名称不是超过50字',
        'zn_name.required' => '活动中文名称不能为空',

        'en_name.max' => '活动英文名称不是超过60字',
        'en_name.required' => '活动英文名称不能为空'

    ];


}
