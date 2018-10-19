<?php

namespace App\Rules;


/**
 * 品牌验证
 * Class CodeInfoRule
 * @package App\Rules
 */
class BrandRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'id' => 'required|positive_integer',
        'zn_name' => 'required|max:20',
        'en_name' => 'required|max:50'
    ];
    //失败信息
    protected $message = [
        'id.required' => '品牌id不能为空',
        'id.positive_integer' => '品牌不是正整数',
        'zn_name.required' => '品牌中文名称不能为空',
        'zn_name.max' => '品牌中文名称最多20个字',
        'en_name.required' => '品牌英文名称不能为空',
        'en_name.max' => '品牌英文名称最多50个字'

    ];


}
