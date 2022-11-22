<?php

namespace App\Http\Controllers\Es;

use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Redis;

class EsController extends BaseController
{

    public function test()
    {
//        return Redis::get('CacheConstKey.REDIS_USER_HYPER_LOG_LOG_1');
    }

}
