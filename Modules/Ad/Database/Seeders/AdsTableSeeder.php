<?php

namespace Modules\Ad\Database\Seeders;

use App\Helpers\EstateDetailsGenerator;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Entities\Category;
use Modules\City\Entities\City;
use Modules\Estate\Entities\Estate;
use Illuminate\Support\Str;
use Modules\Ad\Entities\Ad;
use Modules\Auth\Entities\User;
use Modules\Estate\Services\EstateService;

class AdsTableSeeder extends Seeder
{
    use EstateDetailsGenerator;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::select(['id', 'is_building'])
            ->with([
                'attributes',
                'attributes.values',
            ])
            ->get();
        $users = User::select(['id', 'name', 'phone'])->get();
        $estateService = new EstateService();
        $cities = City::select(['id'])->get();
        for ($i = 0; $i < 400; $i++) {
            $category = $categories->random();
            $estate = Estate::create([
                "city_id" => $cities->random()->id,
                "category_id" => $category->id,
                "neighborhood_id" => null,
                "title" => "test",
                "description" => "test aqaratikom",
                "area" => \rand(100, 100000),
                "age" => rand(1, 20),
                'address' => 'Suadi Arabia',
                'is_building' => $category->is_building,
                "is_furniture" => \rand(0, 1),
                "bedroom" => \rand(1, 10),
                "lat" => generate_coordination(18.329384, 30.983334),
                "long" => generate_coordination(38.026428, 46.738586),
                'type' => 'ad'
            ]);
            $media = $estateService->generateMedia($estate->id);
            $estate->media()->insert($media);
            $estate->details()->insert($this->generateDetails($estate->id, $category));
            $types = ['rent', 'sell'];
            $statuses = ['pending', 'approved', 'cancelled', 'closed'];
            $status = $statuses[rand(0, 3)];
            $user = $users->random();
            Ad::create([
                'uuid' => Str::uuid(),
                'user_id' => $user->id,
                'owner_name' => $user->name,
                'owner_phone' => $user->phone,
                'estate_id' => $estate->id,
                'type' => $types[rand(0, 1)],
                'status' => $status,
                'views' => $status == 'pending' ? 0 : rand(1, 100),
                'price' => rand(10000, 100000000),
                'is_dependable' => true,
                'accepted_at' => $status == 'pending' ? null : now()->toDateTimeString(),
            ]);
        }
        //each category will have 10 ads  with different statuses
        // $this->call("OthersTableSeeder");
    }
}
