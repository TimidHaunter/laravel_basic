<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CheckEmailCode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $request->validate([
            'code'  => 'required',
            'email' => 'required|email',
        ]);

        $key = 'user::' . auth('api')->id() . '::email_code';
        if (Redis::get($key) != md5($request->input('email') . $request->input('code'))) {
            abort('403', '验证码或邮箱验证不通过');
        }

        // 清空缓存
        Redis::del($key);

        return $next($request);
    }
}
