<?php

namespace App\Rules;


/**
 * Id必须是正整数验证
 * Class CodeInfoRule
 * @package App\Rules
 */
class DiscountRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'id' => 'positive_integer',
        'zn_name' => 'required|max:20',
        'number' => 'required|max:500|integer',
        'type' => 'required|in:1,2',
        'en_name' => 'required|max:50',
        'price' => 'price_value',
        'rcent' => 'in:5%,10%,15%,20%,25%,30%,35%,40%,45%,50%',
        'code' => 'required|max:50',
        'threshold'=>'price_value'
    ];
    //失败信息
    protected $message = [
        'id.positive_integer' => '优惠券不是正整数',
        'zn_name.required' => '优惠券中文名称不能为空',
        'zn_name.max' => '优惠券中文名称最多20个字',
        'code.required' => '优惠券代码不能为空',
        'code.max' => '优惠券代码最多50个字',
        'type.required' => '类型不能为空',
        'type.in' => '类型不在指定值',
        'number.required' => '优惠券数量不能为空',
        'number.integer' => '优惠券数量不在正整数',
        'number.max' => '优惠券数量不能超过500',
        'en_name.required' => '优惠券英文名称不能为空',
        'en_name.max' => '优惠券英文名称最多50个字',
        'price.price_value' => '优惠券金额格式不对或者超过百万',
        'threshold.price_value' => '最低购买价格金额格式不对或者超过百万',
        'rcent.in' => '优惠券折扣不在指定值'
    ];


}
