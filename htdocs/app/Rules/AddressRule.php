<?php

namespace App\Rules;


/**
 * 地址验证
 * Class CodeInfoRule
 * @package App\Rules
 */
class AddressRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'name' => 'required|max:40',
        'mobile' => 'required',
        'province' => 'required',
        'city' => 'required',
        'country' => 'required',
        'email' => 'required|email',
        'zip' => 'required|positive_integer'

    ];
    //失败信息
    protected $message = [
        'name.required' => '收件人不能为空',
        'name.max' => '名称超过40个字',
        'mobile.required' => '电话不能为空',
        'province.required' => '州不能为空',
        'city.required' => '城市不能为空',
        'country.required' => '地址1不能为空',
        'zip.required' => '邮编不能为空',
        'email.required' => '邮箱不能为空',
        'email.email' => '邮箱格式不对',
        'zip.positive_integer' => '邮编格式不对'
    ];


}
