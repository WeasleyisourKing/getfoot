<?php

namespace App\Rules;

use Validator, Request;
use App\Exceptions\ParamsException;

/**
 * 验证层基类
 * Class BaseRule
 * @package App\Rules
 */
class BaseRule
{
    //验证规则
    protected $rule = [];

    //不通过信息
    protected $message = [];

    /**
     * 统一使用此方法进行参数验证
     */
    public function goCheck ($status = 400, $code = false)
    {

        $params = Request::all();
        $result = Validator::make($params, $this->rule, $this->message);
        //验证不通过
        if ($result->fails()) {
            $errors = $result->errors();
            $mess = '';
            //获取全部错误信息
            foreach ($errors->all() as $message) {
                $mess .= $message . ';';
            }

            if ($code) {

                $result = [
                    'status' => false,
                    'code' => $status,
                    'data' => $mess
                ];
                $json = json_encode($result);

                return "my({$json})";
            }

            throw new ParamsException([
                'code' => $status,
                'message' => $mess
            ]);
        }
        //验证成功
        return 0;
    }

}
