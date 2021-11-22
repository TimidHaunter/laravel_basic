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
$api->version('v1', function ($api) {
    $api->get('users', 'App\Http\Controllers\TestController@show');

    $api->get('test', [\App\Http\Controllers\TestController::class, 'index']);

    // 命名路由
    $api->get('name', ['as' => 'test.name', 'uses' => 'App\Http\Controllers\TestController@name']);
});
