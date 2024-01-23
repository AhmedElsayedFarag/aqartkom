<?php

namespace Modules\Role\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Entities\User;
use Spatie\Permission\Models\Role;

class RoleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Model::unguard();
        // $this->call("OthersTableSeeder");

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'super-admin']);
        Role::create(['name' => 'customer']);
        Role::create(['name' => 'marketer']);
        Role::create(['name' => 'company']);
    }
}