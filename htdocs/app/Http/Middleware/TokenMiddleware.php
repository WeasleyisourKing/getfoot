<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Model\UsersModel;
use Request;

class TokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * 根据header-token判断用户是否存在
         * @param Request $request
         * @return mixed
         */

        $token = Request::header('token');

        if (!$token) {
            throw new \App\Exceptions\TokenException();
        }

        $user = new UsersModel();
        $info = $user->where('api_token','=',$token)->first();

        if (!$info) {
            throw new \App\Exceptions\UserException([
                'message' => '用户不存在'
            ]);
        }
        //用户id
        $userId = $info->id;
        $request->attributes->add(compact('userId'));


        return $next($request);
    }
}
