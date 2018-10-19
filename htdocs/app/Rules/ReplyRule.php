<?php

namespace App\Rules;


/**
 * 回复验证
 * Class CodeInfoRule
 * @package App\Rules
 */
class ReplyRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'news' => 'required|max:200'
    ];
    //失败信息
    protected $message = [
        'news.required' => '回复不能为空',
        'news.max' => '回复不能超过200字',
    ];


}
