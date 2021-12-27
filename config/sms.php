<?php

return [
    // HTTP 请求的超时时间（秒）
    'timeout' => 5.0,

    // 默认发送配置
    'default' => [
        // 网关调用策略，默认：顺序调用
        'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

        // 默认可用的发送网关
        'gateways' => ['aliyun'],
    ],
    // 可用的网关配置
    'gateways' => [
        'errorlog' => [
            'file' => '/tmp/easy-sms.log',
        ],
        'aliyun' => [
            // 阿里短信服务的配置项
            'access_key_id' => env('SMS_ACCESS_KEY_ID'),
            'access_key_secret' => env('SMS_ACCESS_KEY_SECRET'),
            // 签名
            'sign_name' => '注册验证码',
        ],
    ],
    // 模板
    'template' => 'SMS_181211617',
];
