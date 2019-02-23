<?php

namespace App\Http\Middleware;

use Closure;
use Request;
use \App\Exceptions\TokenException;

class TokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    private $info = 'a5cYTRUc/pINCLo1bCAQmuli4r3OZGl7V3efH/y1irixcAcdTwQAu';

    public function handle($request, Closure $next)
    {
        /**
         * 根据header-token判断用户是否存在
         * @param Request $request
         * @return mixed
         */

        $token = Request::header('token');

        if ($this->info != $token) {
            throw new TokenException([
                'message' => 'token不存在或者无效'
            ]);

        }

        return $next($request);
    }
}
