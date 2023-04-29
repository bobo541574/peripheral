<?php

namespace Bobo\Peripheral\Providers;

use Bobo\Peripheral\Permission\Providers\PermissionServiceProvider;
use Illuminate\Support\ServiceProvider;

class PeripheralServiceProvider extends ServiceProvider {
    
    public function boot()
    {
        $this->app->singleton(PermissionServiceProvider::class, function($app) {
            return new PermissionServiceProvider($app);
        });
    }
}