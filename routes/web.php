<?php

use App\Http\Controllers\Queue\SeckillActivityController;
use App\Http\Controllers\Queue\SendMailDatabaseController;
use App\Http\Controllers\Redis\RedisHyperController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes 浏览器请求的路由
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 视图路由
Route::get('/', function () {
    return view('welcome');
});

Route::get('foo', function () {
    return 'Hello World';
});

// 队列路由
Route::post('queue/mail/database',[SendMailDatabaseController::class, 'store']);

/**
 * Redis秒杀
 */
//初始化秒杀活动
Route::get('queue/seckill/index',[SeckillActivityController::class, 'index']);
Route::get('queue/seckill/start',[SeckillActivityController::class, 'start']);

/**
 * Redis HyperLogLog引用
 */
Route::get('redis/hyper/add',[RedisHyperController::class, 'add']);
