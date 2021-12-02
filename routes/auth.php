<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => 'api.throttle', 'limit' => 60, 'expires' => 1], function ($api){

    // 路由组
    $api->group(['prefix' => 'auth'], function ($api){
        // 用户注册
        $api->post('register', [\App\Http\Controllers\Auth\RegisterController::class, 'store']);
        // 用户登录
        $api->post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
    });

    // 需要登录的路由
    $api->group(['prefix' => 'auth', 'middleware' => 'api.auth'], function($api){
        // 用户登出
        $api->post('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout']);
        // 用户刷新 token
        $api->post('refresh', [\App\Http\Controllers\Auth\LoginController::class, 'refresh']);

        // 阿里云OSS Token
        $api->get('oss/token', [\App\Http\Controllers\Auth\OssController::class, 'token']);
    });

});
