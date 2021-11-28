<?php

$api = app('Dingo\Api\Routing\Router');

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

    $api->group(['prefix' => 'admin'], function($api){

        // 需要登录的路由
        $api->group(['middleware' => 'api.auth'], function($api){
            /**
             * 用户管理
             */
            // 用户管理资源路由
            $api->resource('users', \App\Http\Controllers\Admin\UserController::class, [
                'only' => [
                    'index',
                    'show'
                ]
            ]);
            // 禁、启用用户
            $api->patch('users/{user}/lock', [\App\Http\Controllers\Admin\UserController::class, 'lock']);
        });


    });
});
