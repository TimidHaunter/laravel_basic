<?php

namespace App\Console;

use App\Models\Order;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     * 定义任务调度
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        // 测试定时任务是否开启
//        $schedule->call(function () {
//            info(time());
//        })->everyMinute();

        // 监听订单的有效期，超过10min未支付的，作废掉
        // 真实项目使用长链接，生成订单创建一个长链接
        $schedule->call(function () {
            // 先查出所有未支付的订单
            // 再判断是否超时
            $orders = Order::where('status', 1)
                ->where('created_at', '<', date('Y-d-m H:i:s',time()-60) )

                // 为了避免两次 foreach 循环，在关联模型时候，就拿到数据
                ->with('orderDetails.goods')
                ->get();

            // 循环订单，修改订单状态，还原商品
            try {
                // 开启事务
                DB::beginTransaction();

                // order->orderDetails->goods
                foreach ($orders as $order) {
                    // 修改订单状态
                    $order->status = 5;
                    $order->save();

                    // 还原商品
                    foreach ($order->orderDetails as $details)
                    {
                        $details->goods->increment('stock', $details->num);
                    }
                }

                // 提交事务
                DB::commit();
            } catch(\Exception $e){
                // 错误时事务回滚
                DB::rollBack();
                Log::error($e);
            }

            // 将商品恢复

        })->everyMinute();

        // 备份数据库，清空日志表
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
