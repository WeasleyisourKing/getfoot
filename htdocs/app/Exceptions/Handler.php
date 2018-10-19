<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;


class Handler extends ExceptionHandler
{

    /**
     * 异常处理类
     */
    private $code;

    private $message;

    private $status;

    private $errorCode;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
        BaseException::class,
        NotFoundHttpException::class,
        MethodNotAllowedHttpException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report (Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render ($request, Exception $exception)
    {


        //请求路由 方法错误
        if ($exception instanceof NotFoundHttpException || $exception instanceof MethodNotAllowedHttpException) {

            //不是前端接口
            $arr = parse_url($_SERVER['HTTP_HOST'] . $request->url());
            $res = explode('/', $arr['path']);

            if (!in_array('api', $res)) {
                return redirect('404');
                exit;
            } else {
                $this->code = 404;
                $this->message = '请求路由或者请求方式错误';
                $this->status = false;
                $this->errorCode = 444;
            }

        } //自定义异常 抛出给客户端
        else if ($exception instanceof BaseException) {

            $this->code = $exception->code;
            $this->message = $exception->message;
            $this->status = $exception->status;
            $this->errorCode = $exception->errorCode;
        } else {

            // 如果config配置debug为true 用框架方式显示错误
            if (env('APP_DEBUG')) {
                return parent::render($request, $exception);
            } else {
                //未知错误 记录日志
                $this->code = 200;
                $this->message = '服务器内部错误';
                $this->status = false;
                $this->errorCode = 999;
                //记录日志
                $this->recordErrorLog($exception);
            }
        }
        $result = [];
        $result = [
            'status' => $this->status,
            'message' => $this->message,
            'error_code' => $this->errorCode

        ];
        return response()->json($result, $this->code);

    }

    /**
     * 记录日志
     * @param $exception 异常类
     */
    public function recordErrorLog ($exception)
    {
        $request = new Request;
        $err = [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'code' => $exception->getCode(),
            'url' => $request->fullUrl(),
            'input' => $request->all(),
        ];
        Log::error($exception->getMessage(), $err);

    }
}
