<?php

namespace Axterisko\Inspinia;

use Illuminate\Support\ServiceProvider;
use Axterisko\Inspinia\Console\Commands\InspiniaMakeCommand;
use Spatie\Menu\Laravel\Link;
use Spatie\Menu\Laravel\Menu;

class InspiniaServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/inspinia.php' => config_path('inspinia.php'),
        ], 'config');
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'axterisko');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'inspinia');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');


        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
            $this->commands([
                InspiniaMakeCommand::class,
            ]);
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/inspinia.php', 'inspinia');

        // Register the service the package provides.
        $this->app->singleton('inspinia', function ($app) {
            return new Inspinia;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['inspinia'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/inspinia.php' => config_path('inspinia.php'),
            __DIR__ . '/../resources/views' => resource_path('views/vendor/inspinia')
        ], 'laravel-inspinia');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/axterisko'),
        ], 'inspinia.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/axterisko'),
        ], 'inspinia.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/axterisko'),
        ], 'inspinia.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
