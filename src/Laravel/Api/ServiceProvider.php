<?php

namespace FiveSay\Laravel\Api;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Validator;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     * 是否延迟加载服务提供者
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     * 在容器中注册绑定
     *
     * @return void
     */
    public function register()
    {
        // 
    }

    /**
     * Boot the service provider.
     * 运行注册后的启动服务
     */
    public function boot()
    {
        // 发布配置文件
        $this->publishes([
            __DIR__.'/../../../config/ext.php' => config_path('ext.php'),
        ], 'config');

        // 发布可编辑扩展目录
        $this->publishes([
            __DIR__.'/../../../ext' => base_path('ext'),
        ], 'ext');
        
        // 注册全局中间件
        $this->registerMiddleware('FiveSay\Laravel\Api\Middleware\AccessControlAllowOrigin');

        // 注册自定义验证规则
        $this->registerCustomValidate();
    }

    /**
     * 注册全局中间件
     * @param  string $middleware
     */
    protected function registerMiddleware($middleware)
    {
        $kernel = $this->app['Illuminate\Contracts\Http\Kernel'];
        $kernel->pushMiddleware($middleware);
    }

    /**
     * 注册自定义验证规则
     */
    protected function registerCustomValidate()
    {
        // 让模型支持只读字段的定义
        Validator::extend('read_only', function($attribute, $value, $parameters, $validator) {
            return is_null($value);
        });
        Validator::replacer('read_only', function($message, $attribute, $rule, $parameters) {
            $message = $message ?: '只读字段，禁止赋值';
            return $message;
        });
    }


}
