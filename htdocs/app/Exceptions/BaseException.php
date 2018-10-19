<?php
/**
 * Created by PhpStorm.
 * User: coen
 * Date: 2017/10/26
 * Time: 10:16
 */

namespace App\Exceptions;


class BaseException extends \Exception {

    //http 状态码
    protected $code;

    //错误信息
    protected  $message;

    //请求状态
    protected  $status;

    //自定义错误码
    protected $errorCode;


    public function __construct ($param = []) {

        parent::__construct();
        if (!is_array($param) || empty($param)) return ;

        $classMembers = get_class_vars(get_class($this));
        foreach ($classMembers as $k => $v) {
            if (array_key_exists($k,$param)) {
                $this->$k = $param[$k];
            }
        }
    }
}