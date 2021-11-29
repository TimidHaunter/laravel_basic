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
            // 用户管理资源路由，只用index和show路由
            $api->resource('users', \App\Http\Controllers\Admin\UserController::class, [
                'only' => [
                    'index',
                    'show'
                ]
            ]);
            // 用户禁、启用
            $api->patch('users/{user}/lock', [\App\Http\Controllers\Admin\UserController::class, 'lock']);


            /**
             * 分类管理
             */
            // 分类管理资源路由，排除掉destroy
            $api->resource('category', \App\Http\Controllers\Admin\CategoryController::class, [
                'except' => [
                    'destroy'
                ]
            ]);

            // 分类禁、启用
            $api->patch('category/{category}/status', [\App\Http\Controllers\Admin\CategoryController::class, 'status']);
        });
    });
});
