<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * 队列，存储机制使用数据库，需要建表
 * php artisan queue:table jobs表
 * php artisan migrate
 */
class SendMailDatabase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(\App\Models\SendMail $mail)
    {
        $this->mail = $mail;
    }

    /**
     * Execute the job.
     * 当队列处理器从队列中取出任务时，会调用 handle() 方法
     *
     * @return void
     */
    public function handle()
    {
        //出列，处理业务逻辑
        $this->mail->status = 1;
        $this->mail->tries ++;
        $nowTime = date('Y-m-d H:i:s');

        try {
            $this->mail->update();
            echo '[' . $nowTime . '] sendMail success!';
        } catch (\Exception $e) {
            echo '[' . $nowTime . '] sendMail fail, error: ' . $e->getMessage();
        }
    }
}
