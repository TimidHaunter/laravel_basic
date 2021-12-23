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

//$api->version('v1', ['middleware' => 'api.throttle', 'limit' => 100, 'expires' => 1], function ($api) {
//
//    $api->group(['prefix' => 'test'], function ($api) {
//        $api->get('users', 'App\Http\Controllers\TestController@show');
//
//        $api->get('test', [\App\Http\Controllers\TestController::class, 'index']);
//
//        // 命名路由
//        $api->get('name', ['as' => 'test.name', 'uses' => 'App\Http\Controllers\TestController@name']);
//
//        // 登录
//        $api->post('login', [\App\Http\Controllers\TestController::class, 'login']);
//    });
//
//    // 开启api jwt的路由
//    $api->group(['prefix' => 'test', 'middleware' => 'api.auth'], function ($api){
//        $api->get('users', [\App\Http\Controllers\TestController::class, 'users']);
//    });
//
//    $api->group(['prefix' => 'test'], function ($api){
//        // 内部调用
//        $api->get('inner', [\App\Http\Controllers\TestController::class, 'inner']);
//    });
//});

//$api->version('v2', function($api){
//    $api->group(['prefix' => 'test'], function ($api) {
//        $api->get('inner2', [\App\Http\Controllers\TestController::class, 'inner2']);
//    });
//});


$params = [
    'middleware' => [
        'api.throttle',
        'serializer:array', // 减少 transformer 包裹层
        'bindings'          // 支持路由模型注入
    ],
    'limit' => 60,
    'expires' => 1
];

$api->version('v1', $params, function ($api){
    // 首页数据
    $api->get('/index', [\App\Http\Controllers\Api\IndexController::class, 'index']);


    // 需要登录的路由
    $api->group(['middleware' => 'api.auth'], function ($api) {
        /**
         * 个人中心
         */
        // 用户详情
        $api->get('/user', [\App\Http\Controllers\Api\UserController::class, 'userInfo']);

        // 更新用户信息
        $api->put('/user', [\App\Http\Controllers\Api\UserController::class, 'updateUserInfo']);
    });
});
