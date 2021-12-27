<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     * 应用程序的事件监听器映射
     * 注册事件
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        // OrderPost 事件名字
        // SendEmailToOrderUser 监听者
        'App\Events\OrderPost' => [
            'App\Listeners\SendEmailToOrderUser',
        ],
        // SendSms
        // SendSmsListener
        'App\Events\SendSms' => [
            'App\Listeners\SendSmsListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
