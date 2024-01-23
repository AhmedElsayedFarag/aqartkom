<?php

namespace Modules\BotQuestion\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Entities\User;
use Modules\BotQuestion\Entities\BotQuestion;

class BotQuestionDatabaseSeeder extends Seeder
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
        BotQuestion::insert([
            [
                'question' => 'ماذا ترغب ان توفر لك منصة عقاراتكم ؟',
                'type' => 'select',
                'content' => 'type'
            ],
            [
                'question' => 'ما العقار الذي تريد البحث عنه ؟',
                'type' => 'select',
                'content' => 'category'
            ],
            [
                'question' => 'ما المدينة التي ان ترغب ان تسكن فيها ؟',
                'type' => 'text',
                'content' => 'city'
            ],
            [
                'question' => 'ما هي واجهة المدينة التي ترغب ان تسكن فيها ؟',
                'type' => 'select',
                'content' => 'neighborhood'
            ],
        ]);
    }
}