<?php

namespace App\Rules;


/**
 * 地址验证
 * Class CodeInfoRule
 * @package App\Rules
 */
class SupplierRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'name' => 'required|max:30',
        'mobile' => 'required|max:30',
        'company' => 'required|max:70',
        'address' => 'required|max:150',
        'country' => 'required|max:30',
        'email' => 'required|email'

    ];
    //失败信息
    protected $message = [
        'name.required' => '收件人不能为空',
        'name.max' => '名称超过30个字',

        'mobile.required' => '电话不能为空',
        'mobile.max' => '电话超过30个字',

        'company.required' => '供应商名称不能为空',
        'company.max' => '供应商名称超过70个字',

        'address.required' => '地址不能为空',
        'address.max' => '地址超过150个字',

        'country.required' => '国家不能为空',
        'country.max' => '国家超过30个字',

        'email.required' => '邮箱不能为空',
        'email.email' => '邮箱格式不对',


    ];


}
