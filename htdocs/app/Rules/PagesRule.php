<?php

namespace App\Rules;


/**
 * Id必须是正整数验证
 * Class CodeInfoRule
 * @package App\Rules
 */
class PagesRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'page' => 'positive_integer',
        'limit' => 'positive_integer'
    ];
    //失败信息
    protected $message = [
        'page.positive_integer' => '页数不是正整数',
        'limit.positive_integer' => '显示条数不是正整数'
    ];


}
