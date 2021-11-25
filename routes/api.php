<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// 使用dingo api 路由
$api = app('Dingo\Api\Routing\Router');

// api 404，检查配置文件.env

// 节流，加入中间件 ['middleware' => 'api.throttle', 'limit' => 100, 'expires' => 5]

$api->version('v1', ['middleware' => 'api.throttle', 'limit' => 100, 'expires' => 1], function ($api) {
    $api->get('users', 'App\Http\Controllers\TestController@show');

    $api->get('test', [\App\Http\Controllers\TestController::class, 'index']);

    // 命名路由
    $api->get('name', ['as' => 'test.name', 'uses' => 'App\Http\Controllers\TestController@name']);

    // 登录
    $api->post('login', [\App\Http\Controllers\TestController::class, 'login']);

    // 开启api jwt的路由
    $api->group(['middleware' => 'api.auth'], function ($api){
        $api->get('users', [\App\Http\Controllers\TestController::class, 'users']);
    });


    // 内部调用
    $api->get('inner', [\App\Http\Controllers\TestController::class, 'inner']);
});


