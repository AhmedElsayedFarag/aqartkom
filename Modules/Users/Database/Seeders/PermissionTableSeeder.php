<?php

namespace Modules\Users\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Permission::insert([
            [
                'name' => 'manage-admins',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage-cities',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage-categories',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage-users',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage-customers-messages',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage-packages',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage-pages',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage-slides',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage-subscriptions',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage-settings',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage-ads',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage-auctions',
                'guard_name' => 'web',
            ],
        ]);
        // $this->call("OthersTableSeeder");
    }
}