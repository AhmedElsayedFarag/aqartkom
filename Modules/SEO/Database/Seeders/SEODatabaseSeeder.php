<?php

namespace Modules\SEO\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\SEO\Entities\SEO;

class SEODatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        SEO::insert([
            [
                'key' => 'og:title',
                'value' => 'عقارتكم',
                'type' => 'string'
            ],
            [
                'key' => 'title',
                'value' => 'عقارتكم',
                'type' => 'string'
            ],
            [
                'key' => 'og:type',
                'value' => 'article',
                'type' => 'string'
            ],
            [
                'key' => 'og:url',
                'value' => route('front.index'),
                'type' => 'string'
            ],
            [
                'key' => 'og:description',
                'value' => 'عقارتكم',
                'type' => 'string'
            ],
            [
                'key' => 'og:image:alt',
                'value' => 'عقارتكم',
                'type' => 'string'
            ],
            [
                'key' => 'og:image',
                'value' => asset('front-end/images/mzad.png'),
                'type' => 'image'
            ],
            [
                'key' => 'og:site_name',
                'value' => 'عقارتكم',
                'type' => 'string'
            ],
            [
                'key' => 'og:locale',
                'value' => 'ar',
                'type' => 'string'
            ],
            [
                'key' => 'article:author',
                'value' => 'عقارتكم',
                'type' => 'string'
            ],
            [
                'key' => 'twitter:card',
                'value' => 'summary_large_image',
                'type' => 'string'
            ],
            [
                'key' => 'twitter:site',
                'value' => 'Image',
                'type' => 'string'
            ],
            [
                'key' => 'twitter:creator',
                'value' => 'Image',
                'type' => 'string'
            ],
            [
                'key' => 'twitter:url',
                'value' => route('front.index'),
                'type' => 'string'
            ],
            [
                'key' => 'twitter:title',
                'value' => 'عقارتكم',
                'type' => 'string'
            ],
            [
                'key' => 'twitter:description',
                'value' => 'عقارتكم',
                'type' => 'string'
            ],
            [
                'key' => 'twitter:image',
                'value' => asset('front-end/images/mzad.png'),
                'type' => 'image'
            ], [
                'key' => 'twitter:image:alt',
                'value' => 'عقارتكم',
                'type' => 'string'
            ],
        ]);
        // $this->call("OthersTableSeeder");
    }
}