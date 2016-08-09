# laravel-api-tool
自用 laravel api 辅助工具库


在 `/api/config/app.php` 中注册服务提供者

```php
<?php

    'providers' => [
        ...
        FiveSay\Laravel\Api\ServiceProvider::class,
    ],
```


执行 artisan 命令，发布扩展文件

```
php artisan vendor:publish --provider="FiveSay\Laravel\Api\ServiceProvider"
```


在 `/api/bootstrap/autoload.php` 中引入核心函数库

```php
<?php

define('LARAVEL_START', microtime(true));

// 核心函数定义，最高优先级
require __DIR__.'/../ext/changeCoreHelpers.php';
```