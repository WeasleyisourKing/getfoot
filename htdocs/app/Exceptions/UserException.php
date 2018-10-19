<?php
/**
 * Created by PhpStorm.
 * User: coen
 * Date: 2017/11/16
 * Time: 9:47
 */

namespace App\Exceptions;


class UserException extends BaseException {



    public $code = 400;

    public $message = '用户名已存在';

    public $errorCode = 6002;

    public $status = false;

}