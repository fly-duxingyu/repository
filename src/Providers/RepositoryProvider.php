<?php


namespace Repository\Providers;


use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Illuminate\Support\ServiceProvider;
use Repository\Console\Commands\Creators\CriteriaCreator;
use Repository\Console\Commands\Creators\RepositoryCreator;
use Repository\Console\Commands\MakeRepositoryCommand;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true; //是否延时绑定


    /**
     * Bootstrap the application services.
     * 执行文案register后执行此方法
     * @return void
     */
    public function boot()
    {
        // Config path.
        $config_path = __DIR__ .  '/../../config/repositories.php';

        // Publish config.
        $this->publishes(
            [$config_path => config_path('repositories.php')],
            'repositories'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //注册
        $this->registerBindings();
        $this->registerMakeRepositoryCommand();
        //注册artisan命令
        $this->commands(['command.repository.make','command.Criteria.make']);

        //获取配置文件
        $config_path = __DIR__ . '/../../config/repositories.php';

        // 合并配置文件
        $this->mergeConfigFrom(
            $config_path,
            'repositories'
        );
    }

    /**
     * Register the bindings.
     */
    protected function registerBindings()
    {
        // 注册FileSystem.
        $this->app->instance('FileSystem', new Filesystem());

        // 注册Composer.
        $this->app->bind('Composer', function ($app) {
            return new Composer($app['FileSystem']);
        });
        //注册repository
        $this->app->singleton('RepositoryCreator', function ($app) {
            return new RepositoryCreator($app['FileSystem']);
        });
        //注册CriteriaCreator
        $this->app->singleton('CriteriaCreator', function ($app) {
            return new CriteriaCreator($app['FileSystem']);
        });
    }

    /**
     * Register the make:repository command.
     */
    protected function registerMakeRepositoryCommand()
    {
        $this->app->singleton('command.repository.make', function ($app) {
            return new MakeRepositoryCommand($app['RepositoryCreator'], $app['Composer']);
        });
        //注册CriteriaCreator
        $this->app->singleton('command.Criteria.make', function ($app) {
            return new CriteriaCreator($app['CriteriaCreator'],$app['Composer']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'command.repository.make',
            'command.Criteria.make'
        ];
    }
}