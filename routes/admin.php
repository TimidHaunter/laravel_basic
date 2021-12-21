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

$api->version('v1', $params, function ($api) {

    $api->group(['prefix' => 'admin'], function ($api) {

        // 需要登录的路由
        $api->group(['middleware' => ['api.auth', 'check.permission']], function ($api) {
            /**
             * 用户管理
             * 单个路由要写在资源路由上面，防止被覆盖
             */
            // 用户禁、启用
            $api->patch('users/{user}/lock', [\App\Http\Controllers\Admin\UserController::class, 'lock'])->name('users.lock');

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
            $api->patch('goods/{goods}/on', [\App\Http\Controllers\Admin\GoodsController::class, 'isOn']);

            // 商品推荐
            $api->patch('goods/{goods}/recommend', [\App\Http\Controllers\Admin\GoodsController::class, 'isRecommend']);

            // 商品管理资源路由
            $api->resource('goods', \App\Http\Controllers\Admin\GoodsController::class, [
                'except' => [
                    'destroy'
                ]
            ]);


            /**
             * 评价管理
             */

            // 评价列表
            $api->get('comments', [\App\Http\Controllers\Admin\CommentController::class, 'index']);
            // 评价详情
            $api->get('comments/{comment}', [\App\Http\Controllers\Admin\CommentController::class, 'show']);
            // 评价回复，更新使用patch
            $api->patch('comments/{comment}/reply', [\App\Http\Controllers\Admin\CommentController::class, 'reply']);


            /**
             * 订单管理
             */
            // 订单列表
            $api->get('orders', [\App\Http\Controllers\Admin\OrderController::class, 'index']);
            // 订单详情
            $api->get('orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show']);
            // 订单发货
            $api->patch('orders/{order}/post', [\App\Http\Controllers\Admin\OrderController::class, 'post']);


            /**
             * 轮播图管理
             */
            // 轮播图管理seq更新
            $api->patch('slides/{slide}/seq', [\App\Http\Controllers\Admin\SlideController::class, 'seq']);
            // 轮播图管理资源路由
            $api->resource('slides', \App\Http\Controllers\Admin\SlideController::class);

            /**
             * 菜单管理
             */
            $api->get('menus', [\App\Http\Controllers\Admin\MenuController::class, 'index']);






        });
    });
});
