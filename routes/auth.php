<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => 'api.throttle', 'limit' => 60, 'expires' => 1], function ($api){

    // 路由组
    $api->group(['prefix' => 'auth'], function ($api){
        // 用户注册
        $api->post('register', [\App\Http\Controllers\Auth\RegisterController::class, 'store']);

    });


});
