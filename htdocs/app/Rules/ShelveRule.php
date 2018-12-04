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
        'name' => 'required|max:100',
        'number' => 'required|max:20',
        'remark' => 'max:500',
//        'remark' => 'required|max:500',
        'status' => 'required|in:1,2'
    ];
    //失败信息
    protected $message = [
        'id.required' => 'id不能为空',
        'id.positive_integer' => '用户id不是正整数',
        'name.required' => '货架名称不能为空',
        'name.max' => '货架名称最大100字符',
        'number.required' => '货架编号不能为空',
        'number.max' => '货架编号最大20字符',
          'status.required' => '货架状态不能为空',
//        'remark.required' => '备注名称不能为空',
        'remark.max' => '备注名称最大500字符',
        'status.in' => '货架状态不在指定值'
    ];


}
