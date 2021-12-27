<?php

namespace App\Listeners;

use App\Events\SendSms;
// 事件放入队列
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Overtrue\EasySms\EasySms;

class SendSmsListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SendSms  $event
     * 依赖注入 SendSms 事件，可以将手机号传入 SendSms 事件构造函数
     *
     * @return void
     */
    public function handle(SendSms $event)
    {
        // 事件被触发，通知所有监听者
        // 监听者执行业务逻辑，去发送短信
        $config = config('sms');

        $easySms = new EasySms($config);


        $code = rand(100000, 999999);

        // 缓存验证码
        $key = 'user::' . $event->userId . '::phone_code';
        Redis::setex($key, 30*60, md5($event->phone.$code));
//        Log::info('fry_test', ['info' => 1]);
        Log::info($key, ['info' => $event->phone.'|'.$code]);

        try {
            $easySms->send($event->phone, [
                // 模板 code
                'template' => $config['template'],
                'data' => [
                    'code' => $code
                ],
            ]);
        } catch (\Exception $e) {
            return $e->getExceptions();
        }
    }
}
