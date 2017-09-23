<?php

namespace Bex\Laravel;

use Illuminate\Support\ServiceProvider;

class BkmExpressServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/bkmexpress.php' => config_path('bkmexpress.php')
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/bkmexpress.php', 'bkmexpress'
        );

        $this->app->singleton('bkmexpress', function ($app) {
            return new Bkm(config('bkmexpress'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['bkmexpress'];
    }
}
