<?php

namespace Laoliu\Qiniu\Live;

use Illuminate\Support\ServiceProvider;

class QiniuLiveServiceProvider extends ServiceProvider
{

    /**
     * 延迟加载服务
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // 单例绑定服务
        $this->app->singleton('QiniuLive', function () {
            return new QiniuLive(config('home77.live.accesskey'), config('home77.live.secretkey'), config('home77.live.hubname'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function provides()
    {
        // 因为延迟加载 所以要定义 provides 函数 具体参考laravel 文档
        return ['QiniuLive'];
    }
}
