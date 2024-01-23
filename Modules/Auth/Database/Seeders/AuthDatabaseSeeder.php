<?php

namespace Modules\Auth\Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Auth\Entities\User;

class AuthDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $admin = User::create([
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'name' => 'Admin',
            'type' => 'admin',
            'phone' => '1111111111',
            'mobile_token' => Str::random(150),
            'uuid' => Str::uuid(),
            'remember_token' => Str::random(10),
        ]);
        $admin->syncRoles(['admin', 'super-admin']);

        $customer = User::create([
            'email' => 'customer@email.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'name' => 'Customer',
            'type' => 'customer',
            'phone' => '+966512345678',
            'mobile_token' => Str::random(150),
            'uuid' => Str::uuid(),
            'remember_token' => Str::random(10),
        ]);
        $customer->assignRole('customer');

        $marketer = User::create([
            'name' => 'Marketer',
            'phone' => "+966541515223",
            'email' => 'marketer@email.com',
            'email_verified_at' => now(),
            'type' => 'marketer',
            'password' => Hash::make('12345678'), // password
            'mobile_token' => Str::random(150),
            'uuid' => Str::uuid(),
            'remember_token' => Str::random(10),
        ]);
        $marketer->assignRole('marketer');
        $marketer->marketerProfile()->update([
            'whatsapp_number' => '+966512345678',
            'advertisement_number' => '######'
        ]);
    }
}