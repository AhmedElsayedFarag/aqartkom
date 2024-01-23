<?php

namespace Modules\Category\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Entities\Category;

class CategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $categories = [
            ['name' => 'فيلا', 'icon' => 'default/categories/cat_icon4.png', 'background' => 'default/categories/1.png', 'is_building' => true],
            ['name' => 'شقة', 'icon' => 'default/categories/cat_icon2.png', 'background' => 'default/categories/2.png', 'is_building' => true],
            ['name' => 'عمارة', 'icon' => 'default/categories/cat_icon1.png', 'background' => 'default/categories/3.png', 'is_building' => true],
            ['name' => 'دوبلكس', 'icon' => 'default/categories/cat_icon6.png', 'background' => 'default/categories/4.png', 'is_building' => true],
            ['name' => 'مزرعة', 'icon' => 'default/categories/cat_icon7.png', 'background' => 'default/categories/1.png', 'is_building' => true],
            ['name' => 'استراحة', 'icon' => 'default/categories/cat_icon5.png', 'background' => 'default/categories/2.png', 'is_building' => true],
            ['name' => 'شاليه', 'icon' => 'default/categories/cat_icon5.png', 'background' => 'default/categories/3.png', 'is_building' => true],
            ['name' => 'أرض', 'icon' => 'default/categories/cat_icon3.png', 'background' => 'default/categories/4.png', 'is_building' => false],
        ];

        Category::insert($categories);
        // $this->call("OthersTableSeeder");
    }
}