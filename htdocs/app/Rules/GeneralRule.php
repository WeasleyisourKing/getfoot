<?php

namespace App\Rules;


/**
 * 网站设置接口验证
 * Class UserInfoRule
 * @package App\Rules
 */
class GeneralRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'title' => 'required|max:20',
        'keywords' => 'required|max:50',
        'description' => 'required|max:240'
    ];
    //失败信息
    protected $message = [
        'title.required' => '网站标题不能为空',
        'title.max' => '网站标题不能超过20个字',
        'keywords.required' => '网站关键字不能为空',
        'keywords.max' => '网站关键字不能超过50个字',
        'description.required' => '网站描述不能为空',
        'description.max' => '网站描述不能超过240个字'

    ];


}
