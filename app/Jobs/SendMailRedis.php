<?php

namespace App\Jobs;

use Config;
use Illuminate\Bus\Queueable;
use Illuminate\Cache\RedisLock;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Spatie\Permission\Commands\CacheReset;

/**
 * 使用队列机制发邮件
 */
class SendMailRedis implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 任务尝试最大次数，如果设置了该值将优先于命令行提供的值
     * 命令行格式参数：php artisan queue:work --tries=3
     *
     * @var int
     */
    public $tries = 5;

    /**
     * 任务失败前允许的最大异常数
     *
     * @var int
     */
    public $maxExceptions = 3;

    /**
     * 在超时之前任务可以运行的秒数
     *
     * @var int
     */
    public $timeout = 120;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * 当任务由队列处理时，将调用 handle 方法；
     * 此处主要是写我们业务代码；
     * 任务类创建成功后，可以直接使用任务本身的 dispatch 方法进行分发任务（入列）；
     * 任务分发时，还可以使用 onConnection 和 onQueue 方法来指定任务的链接和队列，举个栗子
     *
     * SendMail::dispatch($mail)->onConnection('sqs')->onQueue('sending_mail')
     *
     * $mail 具体要放入队列的数据
     * sqs 选择的后台队列服务
     * sending_mail 队列名字
     *
     * @return void
     */
    public function handle()
    {
        //你可以在 Redis facade 上调用任意 Redis 命令
        $one = Redis::lpop(Config::get('CacheConstKey.MAIL_ADD'));

        if ($one) {
            $dataOne = json_decode($one, true);
            try {
                //用数据去做一些事
                Log::notice(date('Y-m-d H:i:s') . ' jobs-SendMail-success: ' . "\n\r");
                sleep(10);
            } catch (\Exception $e) {
                //失败，将数据再次丢入队列
                Redis::rpush(Config::get('CacheConstKey.MAIL_ADD'), $one);
                //捕获try中的异常，记录日志
                Log::error(date('Y-m-d H:i:s') . ' jobs-SendMail-error: ' . $e->getMessage() . "\n\r");
            }
        }
    }

//    public function dispatch()
//    {
//        Redis::rpush(Config::get('CacheConstKey.MAIL_ADD'), 1);
//    }
}
