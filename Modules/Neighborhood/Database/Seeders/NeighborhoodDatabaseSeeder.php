<?php

namespace Modules\Neighborhood\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\City\Entities\City;

class NeighborhoodDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $city = City::select(['id'])->where('name', "الرياض")->first();
        $neighborhoods = [
            ['city_id' => $city->id, 'name' => 'شمال الرياض'],
            ['city_id' => $city->id, 'name' => 'غرب الرياض'],
            ['city_id' => $city->id, 'name' => 'جنوب الرياض'],
            ['city_id' => $city->id, 'name' => 'شرق الرياض'],
            ['city_id' => $city->id, 'name' => 'وسط الرياض'],
        ];
        $city->neighborhoods()->insert($neighborhoods);
        // $this->call("OthersTableSeeder");
    }
}