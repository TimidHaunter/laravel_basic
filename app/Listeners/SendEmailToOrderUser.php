<?php

namespace App\Listeners;

use App\Events\OrderPost;
use Config;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailToOrderUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderPost  $event
     * @return void
     */
    public function handle(OrderPost $event)
    {
        $event->order->express_type = $event->express_type;
        $event->order->express_no   = $event->express_no;
        $event->order->status = Config::get('constants.Shipped');; // 发货状态，建议设置成常量
        $event->order->save();

        // 使用邮箱发送
        // 发送邮件耗时，比如发短信，发邮件可以放入队列当中
        // send 换 queue，使用默认队列
        // 配置队列
        Mail::to($event->order->user)->queue(new \App\Mail\OrderPost($event->order));
    }
}
