<?php

namespace FiveSay\Laravel\Api;

use Illuminate\Support\ServiceProvider;

class ServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     * 是否延迟加载服务提供者
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the service provider.
     * 运行注册后的启动服务
     */
    public function boot()
    {
        // 发布配置文件
        $this->publishes([
            __DIR__.'/../config/ext.php' => config_path('ext.php'),
        ], 'config');

        // 发布可编辑扩展目录
        $this->publishes([
            __DIR__.'/../ext' => base_path('ext'),
        ], 'ext');
    }

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


}
