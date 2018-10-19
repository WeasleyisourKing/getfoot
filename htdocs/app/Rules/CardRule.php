<?php

namespace App\Rules;


/**
 * 地址验证
 * Class CodeInfoRule
 * @package App\Rules
 */
class CardRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'firstName' => 'required',
        'lastName' => 'required',
//        'company' => 'string',
        'address' => 'required',
        'state' => 'required',
        'city' => 'required',
        'country' => 'required',
        'mobile' =>  'required',
        'zip' => 'required|positive_integer'

    ];
    //失败信息
    protected $message = [
        'firstName.required' => 'firstName不能为空',
        'lastName.required' => 'lastName不能为空',
//        'company.string' => '公司不是字符串',
        'address.required' => '地址不能为空',
        'state.required' => '州不能为空',
        'mobile.required' => '电话不能为空',
        'city.required' => '城市不能为空',
        'country.required' => '国家不能为空',
        'zip.required' => '邮编不能为空',
        'zip.positive_integer' => '邮编格式不对'
    ];


}
