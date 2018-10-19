<?php
/**
 * Created by PhpStorm.
 * User: coen
 * Date: 2017/10/27
 * Time: 16:40
 */

namespace App\Exceptions;


class ParamsException extends BaseException {


    /**
     * @请求参数验证错误基类
     */

    //http 状态码
    public $code = 400;

    //错误信息
    public  $message;

    //请求状态
    public  $status = false;

    //自定义错误码
    public $errorCode = 1000;

}