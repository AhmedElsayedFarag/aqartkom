<?php

namespace Modules\Page\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Page\Entities\Page;

class PageDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Page::insert([
            ['slug' => 'privacy-policy', 'content' => 'سياسة الخصوصية', 'title' => 'سياسة الخصوصية'],
            ['slug' => 'terms-conditions', 'content' => 'سياسة والاحكام', 'title' => 'سياسة والاحكام'],
            ['slug' => 'auction-policy', 'content' => 'سياسة المزاد', 'title' => 'سياسة المزاد'],
            ['slug' => 'about', 'content' => 'عن التطبيق', 'title' => 'عن التطبيق'],
        ]);
        // $this->call("OthersTableSeeder");
    }
}