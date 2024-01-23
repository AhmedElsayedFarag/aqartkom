<?php

namespace Modules\Category\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Category\Entities\FeaturedCategory;

class FeaturedCategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['category_id' => 1, 'city_id' => 59, 'background' => 'default/categories/1.png', 'type' => 'sell', 'title' => 'فلل للبيع'],
            ['category_id' => 2, 'city_id' => 59, 'background' => 'default/categories/2.png', 'type' => 'sell', 'title' => 'شقق للبيع'],
            ['category_id' => 6, 'city_id' => 59, 'background' => 'default/categories/3.png', 'type' => 'sell', 'title' => 'استراحات للبيع'],
            ['category_id' => 8, 'city_id' => 59, 'background' => 'default/categories/4.png', 'type' => 'sell', 'title' => 'أراضي للبيع'],
        ];
        FeaturedCategory::insert($categories);
    }
}