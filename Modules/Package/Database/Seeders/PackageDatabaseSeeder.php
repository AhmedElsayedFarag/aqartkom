<?php

namespace Modules\Package\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Package\Entities\Package;

class PackageDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Package::insert([
            [
                'title' => 'اشتراك لمدة ٣ اشهر',
                'price' => 1500,
                'months' => 3,
            ], [
                'title' => 'اشتراك لمدة ٦ اشهر',
                'price' => 1500,
                'months' => 6,
            ],
            [
                'title' => 'اشتراك لمدة سنة',
                'price' => 4000,
                'months' => 12,
            ],
        ]);
        // $this->call("OthersTableSeeder");
    }
}
