<?php
/**
 * Created by PhpStorm.
 * User: coen
 * Date: 2017/11/2
 * Time: 11:29
 */

namespace App\Exceptions;


class TokenException extends BaseException {

    public $code = 401;
    public $message = 'Token已经过期或无效Token';
    public $errorCode = 1000;
    public  $status = false;

}