# laravel-api-tool
自用 laravel api 辅助工具库


从 composer 安装

```
composer require five-say/laravel-api-tool -vv
// or
composer update five-say/laravel-api-tool -vv
```


在 `/api/config/app.php` 中注册服务提供者，配置 `JWTFactory` 别名

```php
<?php

    'providers' => [
        ...
        FiveSay\Laravel\Api\ServiceProvider::class,
    ],

    'aliases' => [
        ...
        'JWTAuth' => Tymon\JWTAuth\Facades\JWTAuth::class,
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


在 `/api/app/Http/Kernel.php` 中添加路由中间件

```php
<?php

    protected $routeMiddleware = [
        ...
        'module'   => \FiveSay\Laravel\Api\Middleware\ModuleMiddleware::class,
        'jwt.auth' => \FiveSay\Laravel\Api\Middleware\JwtAuthMiddleware::class,
        'jwt.both' => \FiveSay\Laravel\Api\Middleware\JwtBothMiddleware::class,
        'api.auth' => \Ext\Middleware\ApiAuthMiddleware::class,

    ];
```


修改 `/api/app/Providers/RouteServiceProvider.php` 中的全局路由中间件设置

```php
<?php

    protected function mapWebRoutes(Router $router)
    {
        $router->group([
            // 'namespace' => $this->namespace, 'middleware' => 'web',
            'namespace' => $this->namespace, 'middleware' => 'api',
        ], function ($router) {
            require app_path('Http/routes.php');
        });
    }
```
