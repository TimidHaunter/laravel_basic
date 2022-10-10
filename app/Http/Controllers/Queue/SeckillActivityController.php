<?php

namespace App\Http\Controllers\Queue;

use App\Http\Controllers\Controller;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

/**
 * 秒杀活动，使用Redis
 */
class SeckillActivityController extends Controller
{
    /**
     * 允许进入队列的人数
     * @var int
     */
    public $user_number = 50;

    /**
     * 获得秒杀活动商品队列键名
     * @return mixed
     */
    public function getGoodsStockQueueKey()
    {
        return Config::get('CacheConstKey.SECKILL_ACTIVITY_GOODS_STOCK_QUEUE');
    }

    /**
     * 获得秒杀活动用户排队等待队列键名
     * @return mixed
     */
    public function getUserWaitQueueKey()
    {
        return Config::get('CacheConstKey.SECKILL_ACTIVITY_USER_WAIT_QUEUE');
    }

    /**
     * 获得秒杀活动用户排队成功队列键名
     * @return mixed
     */
    public function getUserSuccessQueueKey()
    {
        return Config::get('CacheConstKey.SECKILL_ACTIVITY_USER_SUCCESS_QUEUE');
    }

    /**
     * 这个方法，相当于点击进入商品详情页,开启秒杀活动
     */
    public function index()
    {
        // 商品库存数量为10
        $goods_number = 10;

        $goodsStockKey = $this->getGoodsStockQueueKey();
        if (!empty(Redis::llen($goodsStockKey))) {
            echo '商品库存已经设置好了，' . Redis::ttl($goodsStockKey) . '秒后可以重新设置';
            return;
        }

        $userWaitKey = $this->getUserWaitQueueKey();
        $userSuccessKey = $this->getUserSuccessQueueKey();
        // 初始化，清空用户抢购排队中、用户抢购成功队列
        Redis::command('del', [$userWaitKey, $userSuccessKey]);

        // 将商品存入redis链表中
        for ($i = 1; $i <= $goods_number; $i++) {
            // lpush从链表头部添加元素
            Redis::lpush($goodsStockKey, $i);
        }

        // 设置过期时间
        $this->setTime();

        // 返回链表的长度
        echo '商品存入队列成功，数量：'.Redis::llen($goodsStockKey) . PHP_EOL;
        echo '商品存入队列成功，分别是：'.json_encode(Redis::lrange($goodsStockKey, 0, -1), true) . PHP_EOL;
    }

    /**
     * 设置 goods_queue 过期时间，相当于活动时间
     * @return void
     */
    public function setTime()
    {
        $goodsStockKey = $this->getGoodsStockQueueKey();
        Redis::expire($goodsStockKey, 120);
    }


    /**
     * 这个方法，相当于点击 抢购 操作
     */
    public function start()
    {
        $uid = mt_rand(1, 99); // 假设用户ID

        $goodsStockKey = $this->getGoodsStockQueueKey();
        $userWaitKey = $this->getUserWaitQueueKey();
        $userSuccessKey = $this->getUserSuccessQueueKey();

        // 如果人数超过50，直接提示被抢完
        if (Redis::llen($userWaitKey) > $this->user_number) {
            echo '遗憾，被抢完了';
            exit;
        }

        // 获取抢购结果,假设里面存了uid
        $result = Redis::lrange($userSuccessKey, 0, 20);
        // 如果有一个用户只能抢一次，可以加上下面判断
        if (in_array($uid, $result)) {
            echo '你已经抢过了';
            exit;
        }

        // 将用户加入排队队列中
        Redis::lpush($userWaitKey, $uid);

        // 从链表的头部删除一个元素，返回删除的元素,因为pop操作是原子性，即使很多用户同时到达，也是依次执行
        $count = Redis::lpop($goodsStockKey);
        if (!$count) {
            echo '被抢完了';
            exit;
        }

        $msg = '抢到的人为：'.$uid.'，商品ID为：'.$count;
        Redis::lpush($userSuccessKey, $msg);
        echo '恭喜你，抢到了';
    }

    /**
     * 查看抢到结果
     */
    public function result()
    {
        $userSuccessKey = $this->getUserSuccessQueueKey();
        $result = Redis::lrange($userSuccessKey, 0, 20);
        dd($result);
    }
}
