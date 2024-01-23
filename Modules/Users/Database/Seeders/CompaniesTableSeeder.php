<?php

namespace Modules\Users\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Entities\User;
use Illuminate\Support\Str;
use Modules\City\Entities\City;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = City::select(['id'])->get();
        for ($i = 0; $i < 20; $i++) {
            $company = User::create([
                'name' => "Company $i",
                'phone' =>  fake()->regexify('^(\+9665)(5|0|3|6|4|9|1|8|7)([0-9]{7})$'),
                'email' => "company$i@email.com",
                'email_verified_at' => now(),
                'type' => 'company',
                'password' => Hash::make('12345678'), // password
                'mobile_token' => Str::random(150),
                'uuid' => Str::uuid(),
                'remember_token' => Str::random(10),
            ]);
            $company->assignRole('company');
            $company->companyProfile()->update([
                'commercial_register_number'  => '######',
                'whatsapp_number' => fake()->regexify('^(\+9665)(5|0|3|6|4|9|1|8|7)([0-9]{7})$'),
                'logo'  => "default/companies/" . rand(1, 6) . ".png",
                'description'  => fake()->sentences(4, true),
                "lat" => generate_coordination(18.329384, 30.983334),
                "long" => generate_coordination(38.026428, 46.738586),
                'uuid' => Str::uuid(),
                'city_id' => $cities->random()->id,
            ]);
        }
        // Model::unguard();

        // $this->call("OthersTableSeeder");
    }
}