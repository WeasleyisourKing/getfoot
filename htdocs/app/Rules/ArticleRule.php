<?php

namespace App\Rules;


/**
 * Id必须是正整数验证
 * Class CodeInfoRule
 * @package App\Rules
 */
class ArticleRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'id' => 'required|positive_integer',
        'zn_name' => 'required|max:50',
        'en_name' => 'required|max:100',
        'zn_content' => 'required',
        'en_content' => 'required',
    ];
    //失败信息
    protected $message = [
        'id.required' => 'id不能为空',
        'zn_name.max' => '文章中文名称不是超过50字',
        'zn_name.required' => '文章中文名称不能为空',

        'en_name.max' => '文章英文名称不是超过100字',
        'en_name.required' => '文章英文名称不能为空',

        'zn_content.required' => '文章中文内容不能为空',
        'en_content.required' => '文章英文内容不能为空'

    ];


}
