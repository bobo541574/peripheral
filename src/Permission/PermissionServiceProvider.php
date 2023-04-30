<?php

namespace Bobo\Peripheral\Permission;

use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider {
    
    public function boot()
    {
        $this->publishConfigs();

        $this->publishMigrations();
    }

    public function publishConfigs()
    {
        $this->publishes([
            __DIR__ . '/config/permissions.php' => config_path('permissions.php'),
            __DIR__ . '/config/roles.php' => config_path('roles.php'),
        ], 'config');
    }

    public function publishMigrations()
    {
        $timestamp = date('Y_m_d_His', time());

        
        if (!class_exists('CreateRolesTable')) {
            $stub = __DIR__ . '/database/migrations/create_roles_table.php.stub';
            
            $target = $this->app->databasePath().'/migrations/'.$timestamp.'_create_roles_table.php';
            
            $this->publishes([$stub => $target], 'migrations');
        }

        if (!class_exists('CreatePermissionsTable')) {
            $stub = __DIR__ . '/database/migrations/create_permissions_table.php.stub';
            
            $target = $this->app->databasePath().'/migrations/'.$timestamp.'_create_permissions_table.php';
            
            $this->publishes([$stub => $target], 'migrations');
        }

        return;
    }
}