<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CheckPhoneCode
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
            'phone' => 'required',
        ]);

        // 验证 code
        $phone = $request->input('phone');
        $code = $request->input('code');

        $key = 'user::' . auth('api')->id() . '::phone_code';
        if (Redis::get($key) != md5($phone . $code)) {
            abort('404', '验证码或手机号错误');
        }

        // 清空缓存
        Redis::del($key);

        return $next($request);
    }
}
