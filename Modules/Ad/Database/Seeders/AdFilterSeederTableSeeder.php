<?php

namespace Modules\Ad\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Ad\Entities\AdFilter;

class AdFilterSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $data = [
            ['name' => 'اقل سعر', 'group' => 'prices', 'values' => \json_encode([
                100,
                1000,
                10000,
                100000,
                1000000,
                10000000
            ])],
            ['name' => 'اعلى سعر', 'group' => 'prices', 'values' => \json_encode([
                1000,
                10000,
                100000,
                1000000,
                10000000,
                100000000
            ])],
            ['name' => 'اقل مساحة', 'group' => 'area', 'values' => \json_encode([
                100,
                1000,
                10000,
            ])],
            [
                'name' => 'اعلى مساحة', 'group' => 'area', 'values' => \json_encode([
                    1000,
                    10000,
                    100000,
                ],)
            ],
            [
                'name' => 'عدد غرف النوم', 'group' => 'bedroom', 'values' => \json_encode([
                    1, 2, 3, 4, 5, 6, 7, 8, 9, 10
                ],)
            ],
            [
                'name' => 'عمر العقار', 'group' => 'age', 'values' => \json_encode([
                    ['name' => 'بناء جديد', 'values' => [0, 1]],
                    ['name' => '1-3', 'values' => [1, 3]],
                    ['name' => '3-5', 'values' => [3, 5]],
                    ['name' => '5-10', 'values' => [5, 10]],
                ]),
            ]
        ];
        AdFilter::insert($data);
        // $this->call("OthersTableSeeder");
    }
}