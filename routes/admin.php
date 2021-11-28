<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => 'api.throttle', 'limit' => 60, 'expires' => 1], function ($api){

    $api->group(['prefix' => 'admin'], function($api){

        // 需要登录的路由
        $api->group(['middleware' => 'api.auth'], function($api){
            /**
             * 用户管理
             */
            // 用户管理资源路由
            $api->resource('users', \App\Http\Controllers\Admin\UserController::class, [
                'only' => ['index', 'show']
            ]);
            // 禁、启用用户
//            $api->patch('users/{user}/lock', \App\Http\Controllers\Admin\UserController::class, 'lock');
        });


    });
});
