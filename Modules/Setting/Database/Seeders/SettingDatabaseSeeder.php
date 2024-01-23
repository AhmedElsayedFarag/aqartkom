<?php

namespace Modules\Setting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Setting\Entities\Settings;

class SettingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Settings::insert([
            ['key' => 'phone',              'group' => 'contact-us',    'value' => '+966512345678'],
            ['key' => 'whatsapp',           'group' => 'contact-us',    'value' => '+966512345678'],
            ['key' => 'facebook',           'group' => 'contact-us',    'value' => 'https://facebook.com'],
            ['key' => 'twitter',            'group' => 'contact-us',    'value' => 'https://twitter.com'],
            ['key' => 'instagram',          'group' => 'contact-us',    'value' => 'https://instagram.com'],
            ['key' => 'linkedin',           'group' => 'contact-us',    'value' => 'https://linkedin.com'],
            ['key' => 'auction_price',      'group' => 'auction',       'value' => '1000'],
            ['key' => 'auction_document',   'group' => 'auction',       'value' => '#'],
            ['key' => 'google_map',         'group' => 'apis',          'value' => '#'],
            ['key' => 'payment_gateway',    'group' => 'apis',          'value' => '#'],
            ['key' => 'statistics',         'group' => 'apis',          'value' => '#'],
            ['key' => 'sms_gateway',        'group' => 'apis',          'value' => '#'],
            ['key' => 'app_version',        'group' => 'app',          'value' => '1.1.4'],
            ['key' => 'app_store',          'group' => 'app',          'value' => 'https://apps.apple.com/us/app/%D8%B9%D9%82%D8%A7%D8%B1%D8%A7%D8%AA%D9%83%D9%85-aqaratikom/id1615580720'],
            ['key' => 'google_play',        'group' => 'app',          'value' => 'https://play.google.com/store/apps/details?id=com.fivegfordesign.aqaratikom'],
            ['key' => 'image',              'group' => 'app',          'value' => 'default/image.png'],

        ]);
        // $this->call("OthersTableSeeder");
    }
}