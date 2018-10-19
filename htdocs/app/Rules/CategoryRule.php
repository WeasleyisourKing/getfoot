<?php

namespace App\Rules;


/**
 * 分类验证
 * Class CodeInfoRule
 * @package App\Rules
 */
class CategoryRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'id' => 'required|positive_integer',
        'zn_name' => 'required|max:20',
        'icon' => 'required|max:120',
        'en_name' => 'required|max:50'
    ];
    //失败信息
    protected $message = [
        'id.required' => '分类id不能为空',
        'id.positive_integer' => '分类不是正整数',
        'zn_name.required' => '分类中文名称不能为空',
        'zn_name.max' => '分类中文名称最多20个字',
        'icon.required' => '分类图标样式不能为空',
        'icon.max' => '分类图标样式最多120个字',
        'en_name.required' => '分类英文名称不能为空',
        'en_name.max' => '分类英文名称最多50个字'

    ];


}
