<?php

namespace JoeCianflone\InertiaResource;

use Illuminate\Support\ServiceProvider;
use JoeCianflone\InertiaResource\Commands\MakeResource;

class InertiaResourceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/inertia-resource.php', 'inertia-resource'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/inertia-resource.php' => config_path('inertia-resource.php'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeResource::class,
            ]);
        }        
    }
}
