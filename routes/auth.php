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
        // 用户修改密码
        $api->put('password/update', [\App\Http\Controllers\Auth\PasswordController::class, 'updatePassword']);

        // 发送邮件验证码
        $api->post('email/code', [\App\Http\Controllers\Auth\BindController::class, 'emailCode']);
        // 接受验证码，验证code，修改邮件
        $api->post('email/update', [\App\Http\Controllers\Auth\BindController::class, 'updateEmail']);


        // 发送手机验证码
        $api->post('phone/code', [\App\Http\Controllers\Auth\BindController::class, 'phoneCode']);
        // 接受验证码，验证code，更换手机
        $api->post('phone/update', [\App\Http\Controllers\Auth\BindController::class, 'updatePhone']);
    });

});
