<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * 发货通知邮件
 */
class OrderPost extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new message instance.
     * 外部 order 类依赖注入到 OrderPost 类，赋值给私用属性 $order
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     * 发邮件
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.order-post', [
            'order' => $this->order
        ]);
    }
}
