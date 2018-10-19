<?php
/**
 * Created by PhpStorm.
 * User: coen
 * Date: 2017/11/1
 * Time: 16:36
 */

namespace App\Exceptions;


class WeChatException extends BaseException {

    public $code = 404;
    public $message = '微信服务器接口调用失败';
    public $errorCode = 999;
    public  $status = false;

}