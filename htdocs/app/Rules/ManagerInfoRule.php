<?php

namespace App\Rules;


/**
 * 管理员信息验证
 * Class ManagerInfoRule
 * @package App\Rules
 */
class ManagerInfoRule extends BaseRule
{
    //验证规则
    protected $rule = [
        'name' => 'required|max:15',
        'role' => 'required',
        'status' => 'required|in:1,2',
    ];
    //失败信息
    protected $message = [
        'name.required' => '管理员名称不能为空',
        'name.max' => '专管理员名称不能超过15个字',
        'role.required' => '管理员角色不能为空',
        'status.required' => '管理员状态不能为空',
        'status.in' => '管理员状态类型不是指定范围',
    ];


}
