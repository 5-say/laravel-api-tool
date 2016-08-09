<?php

/**
 * php artisan config:cache 执行后，将不再读取 .env 文件
 * 因此所有拓展的 env 配置，均需在此引用
 * 之后的程序中通过 config() 函数调用
 */

return [

    // 允许跨域 api 调用的客户端域名
    'allowClientOrigin' => [
        'localhost',
    ],

    // 接口模拟数据调试
    'api' => [

        'debug' => env('API_DEBUG', false),

        'admin' => [
            'auth_user_id'    => env('ADMIN_AUTH_USER_ID'),
            'auth_user_model' => env('ADMIN_AUTH_USER_MODEL'),
        ],

        'home' => [
            'auth_user_id'    => env('HOME_AUTH_USER_ID'),
            'auth_user_model' => env('HOME_AUTH_USER_MODEL'),
        ],

    ],

];
