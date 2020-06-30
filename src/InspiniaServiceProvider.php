<?php

namespace Axterisko\Inspinia;

use Axterisko\Inspinia\Console\Commands\InspiniaMakeCommand;
use Axterisko\Inspinia\Middleware\PasswordNotExpired;
use Illuminate\Support\ServiceProvider;

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
        ], 'laravel-inspinia-config');

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'inspinia');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'inspinia');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this->publishes([
            __DIR__ . '/../config/inspinia.php' => config_path('inspinia.php'),
            __DIR__ . '/../resources/views' => resource_path('views/vendor/inspinia'),
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/inspinia'),
        ], 'laravel-inspinia');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        $this->app['router']->aliasMiddleware('password.not-expired', PasswordNotExpired::class);


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
            __DIR__ . '/../resources/views' => resource_path('views/vendor/inspinia'),
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/inspinia'),
        ], 'laravel-inspinia');


        // Registering package commands.
        $this->commands([
            InspiniaMakeCommand::class,
        ]);
    }
}
