<?php

namespace App\Rules;


/**
 * 邮费设置验证
 * Class CodeInfoRule
 * @package App\Rules
 */
class FreightRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'threshold' => 'required|price_value',
        'freight' => 'required|price_value'
    ];
    //失败信息
    protected $message = [
        'threshold.required' => '阀值不能为空',
        'threshold.price_value' => '阀值金额格式不对或者超过百万',
        'freight.required' => '运费不能为空',
        'freight.price_value' => '运费金额格式不对或者超过百万'
    ];


}
