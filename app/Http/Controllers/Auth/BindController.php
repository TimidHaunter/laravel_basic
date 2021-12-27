<?php

namespace App\Http\Controllers\Auth;

use App\Events\SendSms;
use App\Http\Controllers\BaseController;
use App\Mail\SendCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

//use Illuminate\Support\Facades\Redis;

/**
 * 绑定邮箱
 */
class BindController extends BaseController
{
    public function __construct()
    {
        // 中间件只针对某些方法生效
        $this->middleware(['check.phone.code'])->only(['updatePhone']);
    }

    /**
     * 获取邮件验证码
     */
    public function emailCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // 发送验证码到邮件
        // 使用 Mail 门面
        $email = $request->input('email');
//        $code = rand(100000, 999999);
//        $key = 'user::' . auth('api')->id();
////        Cache::store('redis')->setex($key, 30*60, md5($email.$code));
//        Redis::setex($key, 30*60, md5($email.$code));

        // 直接使用发送邮件
//        Mail::to($email)->send(new SendCode($email));

        // 使用队列发送邮件
        Mail::to($email)->queue(new SendCode($email));

        return $this->response->noContent();
    }

    /**
     * 更新用户邮箱
     */
    public function updateEmail(Request $request)
    {
        $request->validate([
            'code'  => 'required',
            'email' => 'required|email',
        ]);

        // 验证 code
        $email = $request->input('email');
        $code = $request->input('code');

        $key = 'user::' . auth('api')->id() . '::email_code';
        if (Redis::get($key) != md5($email . $code)) {
            return $this->response->errorBadRequest('验证码或邮箱错误!');
        }

        // 清空缓存
        Redis::del($key);

        // 更新用户邮箱
        $user = auth('api')->user();
        $user->email = $email;
        $user->save();

        return $this->response->noContent();
    }

    /**
     * 发送手机验证码
     */
    public function phoneCode(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^1[3-9]\d{9}$/',
        ]);

        // 事件，发送短信事件
        // 调用事件
        $phone = $request->input('phone');
        $userId = auth('api')->id();
//        $product = $request->input('product');
        SendSms::dispatch($phone, $userId);


        return $this->response->noContent();
    }

    /**
     * 验证手机号
     */
    public function updatePhone(Request $request)
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
            return $this->response->errorBadRequest('验证码或手机号错误!');
        }

        // 清空缓存
        Redis::del($key);

        // 更新用户邮箱
        $user = auth('api')->user();
        $user->phone = $phone;
        $user->save();

        return $this->response->noContent();
    }
}
