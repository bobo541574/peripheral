<?php

namespace Bobo\Peripheral\Permission;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Laravel\Prompts\Output\ConsoleOutput;
use Illuminate\Console\Concerns\InteractsWithIO;
use Bobo\Peripheral\Permission\Commands\CreateRole;
use Bobo\Peripheral\Permission\Commands\InstallRole;
use Bobo\Peripheral\Permission\Commands\CreatePermission;
use Bobo\Peripheral\Permission\Commands\InstallPermission;

class PermissionServiceProvider extends ServiceProvider
{
    use InteractsWithIO;

    public function __construct()
    {
        parent::__construct(app());

        $this->output = new ConsoleOutput();
    }

    public function boot()
    {
        $this->publishConfigs();

        $this->publishMigrations();

        $this->publishCommands();
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

        $filesystem = $this->app->make(Filesystem::class);

        $files = [
            'create_roles_table.php',
            'create_permissions_table.php'
        ];

        foreach ($files as $file) {
            $stub = __DIR__ . DIRECTORY_SEPARATOR . 'database/migrations' . DIRECTORY_SEPARATOR . $file . '.stub';

            $target = $this->app->databasePath() . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR;

            $record = collect($target)
                ->flatMap(fn ($path) => $filesystem->glob($path . "*_" . $file));

            if ($record->count() == 0) {
                $this->publishes([$stub => $target . $timestamp . '_' . $file], 'migrations');
            }

        }

        return;
    }

    public function publishCommands()
    {
        $this->commands([
            InstallPermission::class,
            InstallRole::class,

            CreateRole::class,
            CreatePermission::class,
        ]);
    }
}