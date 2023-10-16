<?php

namespace Bobo\Peripheral\Permission\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Bobo\Peripheral\Permission\Models\Permission;

class InstallPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Permissions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->line("++++++++++Start Permissions Installing++++++++++");

        DB::beginTransaction();

        DB::transaction(function() {
            if (!file_exists(config_path('permissions.php'))) {
                $this->info("Your need to 'php artisan vendor:publish' and then publish 'permissions.php' file.");
                
                return;
            }

            Permission::truncate();

            $count = 0;

            $permissions = collect(config('permissions'));

            $data = $permissions->flatMap(function($permission) use (&$count) {
                return collect($permission['list'])
                    ->map(function($list) use (&$count) {
                        $count++;
                        return [
                            'name' => json_encode([
                                'en' => $list['en'],
                                'mm' => $list['mm'],
                            ]),
                            'slug' => Str::slug($list['en']),
                            'created_at' => now(),
                            'deleted_at' => now(),
                        ];
                    });
            })
            ->toArray();

            Permission::insert($data);

            $this->info($count . ' permissions are successfully installed!');

        });

        return $this->info("++++++++++End Permissions Installing++++++++++");
    }
}
