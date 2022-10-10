<?php

namespace App\Http\Controllers\Redis;

use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Redis;
use Config;

class RedisHyperController extends BaseController
{

    public function getUserHyperLog()
    {
        return Config::get('CacheConstKey.REDIS_USER_HYPER_LOG_LOG_1');
    }

    public function add()
    {
        $userHyperLog = $this->getUserHyperLog();
        $user_number = 30000;
        $start_time = time();
        for ($i = 1; $i <= $user_number; $i++) {
            // pfadd 添加用户
            Redis::pfadd($userHyperLog, ["User".$i]);
        }
        $count = Redis::pfcount($userHyperLog);
        $end_time = time();
        echo "一共有" . $count . "个用户点击。" . PHP_EOL;
        echo "共耗时" . ($end_time - $start_time) . "秒。" . PHP_EOL;
    }
}
