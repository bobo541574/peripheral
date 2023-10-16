<?php

namespace Bobo\Peripheral\Permission\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Bobo\Peripheral\Permission\Models\Role;

class InstallRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Roles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("++++++++++Start Roles Installing++++++++++");

        DB::transaction(function () {
            if (!file_exists(config_path('roles.php'))) {
                $this->info("Your need to 'php artisan vendor:publish' and then publish 'roles.php' file.");

                return;
            }

            $count = 0;

            $roles = collect(config('roles'));

            $roles->map(function ($role) use (&$count) {
                $count++;

                $slug = Str::slug($role['en']);

                Role::updateOrCreate([
                    'slug' => $slug
                ], [
                    'name' => [
                        'en' => $role['en'],
                        'mm' => $role['mm'],
                    ],
                    'slug' => $slug,
                    'permissions' => ($slug === 'tech-admin') ? DB::table('permissions')->select('slug')->pluck('slug')->toArray() : [],
                ]);
            })
                ->toArray();

            $this->info($count . ' roles are successfully installed!');


            $this->info("++++++++++End Roles Installing++++++++++");
        });
    }
}
