<?php
/**
 * Laravel IDE Helper Generator
 *
 * @author    Barry vd. Heuvel <barryvdh@gmail.com>
 * @copyright 2014 Barry vd. Heuvel / Fruitcake Studio (http://www.fruitcakestudio.nl)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/barryvdh/laravel-ide-helper
 */

namespace Repository\Provider;


use Bosnadev\Repositories\Console\Commands\Creators\CriteriaCreator;
use Bosnadev\Repositories\Console\Commands\Creators\RepositoryCreator;
use Illuminate\Support\ServiceProvider;
use Repository\Console\ApiDocCommand;

class RepositoryServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'command.apidoc',
            function ($app) {
                return new ApiDocCommand();
            }
        );
        // Repository creator.
        $this->app->singleton('RepositoryCreator', function ($app)
        {
            return new RepositoryCreator($app['FileSystem']);
        });

        // Criteria creator.
        $this->app->singleton('CriteriaCreator', function ($app)
        {
            return new CriteriaCreator($app['FileSystem']);
        });
        $this->commands(
            'command.apidoc'
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('command.apidoc');
    }

}
