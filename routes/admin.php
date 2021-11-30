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
             * 单个路由要写在资源路由上面，防止被覆盖
             */
            // 用户禁、启用
            $api->patch('users/{user}/lock', [\App\Http\Controllers\Admin\UserController::class, 'lock']);

            // 用户管理资源路由，只用index和show路由
            $api->resource('users', \App\Http\Controllers\Admin\UserController::class, [
                'only' => [
                    'index',
                    'show'
                ]
            ]);



            /**
             * 分类管理
             */
            // 分类禁、启用
            $api->patch('category/{category}/status', [\App\Http\Controllers\Admin\CategoryController::class, 'status']);

            // 分类管理资源路由，排除掉destroy
            $api->resource('category', \App\Http\Controllers\Admin\CategoryController::class, [
                'except' => [
                    'destroy'
                ]
            ]);



            /**
             * 商品管理
             */
            // 商品上架
            $api->patch('good/{good}/on', [\App\Http\Controllers\Admin\GoodsController::class, 'isOn']);

            // 商品推荐
            $api->patch('good/{good}/recommend', [\App\Http\Controllers\Admin\GoodsController::class, 'isRecommend']);

            // 商品管理资源路由
            $api->resource('goods', \App\Http\Controllers\Admin\GoodsController::class, [
                'except' => [
                    'destroy'
                ]
            ]);




        });
    });
});
