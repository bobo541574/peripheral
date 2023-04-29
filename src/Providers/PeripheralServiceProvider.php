<?php

namespace Bobo\Peripheral\Providers;

use Illuminate\Support\ServiceProvider;

class PeripheralServiceProvider extends ServiceProvider {
    
    public function boot()
    {
        $this->app->singleton(PeripheralServiceProvider::class, function($app) {
            return new PeripheralServiceProvider($app);
        });
    }
}