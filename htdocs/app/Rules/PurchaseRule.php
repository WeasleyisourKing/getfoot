<?php

namespace App\Rules;


/**
 * Id必须是正整数验证
 * Class CodeInfoRule
 * @package App\Rules
 */
class PurchaseRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'name' => 'required|max:100',
        'supplier' => 'required|max:100',
         'price' => 'price_value',
        'remark' => 'max:500'
    ];
    //失败信息
    protected $message = [
        'name.required' => '采购人不能为空',
        'name.max' => '采购人不能超过100个字符',
        'supplier.required' => '供货商不能为空',
        'supplier.max' => '供货商不能超过100个字符',
        'price.price_value' => '价格格式不对',
//        'remark.required' => '备注不能为空',
        'remark.max' => '备注不能超过500个字符'
    ];


}
