<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

/**
 * 发送绑定账号邮件
 */
class SendCode extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // 生成六位 code 发送给用户
        // 逻辑可以写在这里
        $code = rand(100000, 999999);
        // 存储邮箱和code码
        $key = 'user::' . auth('api')->id() . '::email_code';
        Redis::setex($key, 30*60, md5($this->email.$code));
        echo $this->email.$code;
        return $this->view('emails.send-code', ['code' => $code]);
    }
}
