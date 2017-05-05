<?php

namespace Redrain\YouDao;

use Illuminate\Support\ServiceProvider;
class YouDaoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $app = app();

        $routeConfig = [
            'namespace' => 'Redrain\YouDao\Controllers',
            'prefix' => 'youdao',
            'middleware' => [],
        ];

        $app['router']->group($routeConfig, function ($router) {
            $router->get('/assets/stylesheets', [
                'uses' => 'AssetController@getCss',
                'as' => 'laravel.youdao.assets.css',
            ]);

            $router->get('/assets/javascript', [
                'uses' => 'AssetController@getJs',
                'as' => 'laravel.youdao.assets.js',
            ]);

            $router->get('/fanyi/get/{keyword}', [
                'uses' => 'YouDaoController@get',
            ]);
        });
        if ($app->runningInConsole() || $app->environment('testing')) {
            return;
        }
        ob_start();
        echo '<script src="'.route('laravel.youdao.assets.js').'"></script>';
        echo '<link rel="stylesheet" type="text/css" property="stylesheet" href="'.route('laravel.youdao.assets.css').'">';
        echo "<div class='youdao_container' style='display:none;position:absolute;background:#fff;'></div>";


        //发布配置文件
        $this->publishes([__DIR__.'/config/youdao.php' => config_path('youdao.php')]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //合并config文件
        $configPath = __DIR__ . '/config/youdao.php';
        $this->mergeConfigFrom($configPath, 'youdao');

        $this->app->singleton('youdao', function(){
            return new LaravelYouDao();
        });
    }

}
