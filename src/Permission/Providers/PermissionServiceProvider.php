<?php

namespace Bobo\Peripheral\Permission\Providers;

use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider {
    
    public function boot()
    {
        $this->publishMigrations();
    }

    public function publishMigrations()
    {
        $timestamp = date('Y_m_d_His', time());

        
        if (!class_exists('CreateRolesTable')) {
            $stub = __DIR__ . '/database/migrations/create_roles_table.php.stub';
            
            $target = $this->app->databasePath().'/migrations/'.$timestamp.'_create_roles_table.php';
            
            return $this->publishes([$stub => $target], 'migrations');
        }

        if (class_exists('CreatePermissionsTable')) {
            $stub = __DIR__ . '/database/migrations/create_permissions_table.php.stub';
            
            $target = $this->app->databasePath().'/migrations/'.$timestamp.'_create_permissions_table.php';
            
            return $this->publishes([$stub => $target], 'migrations');
        }

        return;
    }
}