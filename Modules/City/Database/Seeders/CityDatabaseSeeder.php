<?php

namespace Modules\City\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\City\Entities\City;

class CityDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $cities = [
            ["name" => "ابها", "lat" => 18.2167, "long" => 42.5000],
            ["name" =>  "الدلم", "lat" => 23.976619, "long" => 47.155709],
            ["name" => "الابواء", "lat" => 23.10759997, "long" => 39.09712001],
            ["name" =>  "الأرطاوية", "lat" => 26.51466999, "long" => 45.34978007],
            ["name" => "البكيرية", "lat" => 26.161624, "long" => 43.656722],
            ["name" => "بدر", "lat" => 23.755863, "long" => 38.757761],
            ["name" =>  "بلجرشي", "lat" => 19.84112005, "long" => 41.56252003],
            ["name" => "بيشة", "lat" => 18.37224002, "long" => 42.65382004],
            ["name" => "الشبارقة", "lat" => 18.2333, "long" => 42.43916667],
            ["name" => "القصيم", "lat" => 26.094088, "long" => 43.973454],
            ["name" => "بريدة", "lat" => 26.3333, "long" => 43.9667],
            ["name" =>  "الباحة", "lat" => 20.0129, "long" => 41.4677],
            ["name" =>  "الدمام", "lat" => 26.399250, "long" => 49.984360],
            ["name" =>  "الظهران", "lat" => 26.236355, "long" => 50.032600],
            ["name" =>  "ضرما", "lat" => 24.60411001, "long" => 46.13181995],
            ["name" =>  "ذهبان", "lat" => 21.933, "long" => 39.10282004],
            ["name" =>  "الدرعية", "lat" => 24.64344003, "long" => 43.4959],
            ["name" => "ضبا", "lat" => 27.36211995, "long" => 35.68198997],
            ["name" =>  "دومة الجندل", "lat" => 29.81786995, "long" => 39.86566997],
            ["name" =>  "الدوادمي", "lat" => 24.507143, "long" => 44.408798],
            ["name" =>  "القويعية", "lat" => 24.046389, "long" => 45.265556],
            ["name" =>  "حوطة سدير", "lat" => 25.59691998, "long" => 45.61963003],
            ["name" => "حقل", "lat" => 29.30102998, "long" => 34.94863003],
            ["name" =>  "الحريق", "lat" => 25.45085999, "long" => 45.40127001],
            ["name" => "الحائل", "lat" => 27.523647, "long" => 41.696632],
            ["name" => "حوطة بني تميم", "lat" => 23.49761003, "long" => 46.86429996],
            ["name" => "الهفوف", "lat" => 25.3608, "long" => 49.5997],
            ["name" => "حريملاء", "lat" => 25.994478, "long" => 45.318161],
            ["name" => "حفر الباطن", "lat" => 28.446959, "long" => 45.948944],
            ["name" =>  "جلاجل", "lat" => 25.68160004, "long" => 45.45567002],
            ["name" =>  "جدة", "lat" => 21.492500, "long" => 39.177570],
            ["name" => "جيزان", "lat" => 16.909683, "long" => 42.567902],
            ["name" =>  "الجبيل", "lat" => 26.959771, "long" => 49.568742],
            ["name" =>  "الخفجي", "lat" => 28.43980997, "long" => 48.49033999],
            ["name" =>  "خيبر", "lat" => 25.71837, "long" => 39.27875995],
            ["name" =>  "خميس مشيط", "lat" => 18.329384, "long" => 42.759365],
            ["name" =>  "السيح", "lat" => 25.98947003, "long" => 43.23184996],
            ["name" =>  "الخبر", "lat" => 26.217191, "long" => 50.197138],
            ["name" =>  "لحيان", "lat" => 21.06435004, "long" => 40.47183004],
            ["name" =>  "الليث", "lat" => 20.15267003, "long" => 40.27223003],
            ["name" =>  "المجمعة", "lat" => 19.87112997, "long" => 42.55949996],
            ["name" =>  "المبرز", "lat" => 25.4100, "long" => 49.5808],
            ["name" =>  "المدينة المنورة", "lat" => 24.470901, "long" => 39.612236],
            ["name" => "مكة المكرمة", "lat" => 21.422510, "long" => 39.826168],
            ["name" => "المزاحمية", "lat" => 24.464924, "long" => 46.273952],
            ["name" =>  "نجران", "lat" => 17.4917, "long" => 44.1322],
            ["name" =>  "نجد", "lat" => 20.559454, "long" => 44.865658],
            ["name" =>  "النماص", "lat" => 19.12173995, "long" => 42.13678004],
            ["name" =>  "مدينة العيون", "lat" => 24.55455001, "long" => 39.57890998],
            ["name" => "القطيف", "lat" => 26.565191, "long" => 49.996376],
            ["name" =>  "القيصومة", "lat" => 28.32198001, "long" => 46.12942998],
            ["name" => "القنفذة", "lat" => 19.12722996, "long" => 41.09060996],
            ["name" =>  "القريات", "lat" => 31.345425, "long" => 37.333614],
            ["name" =>  "رابغ", "lat" => 22.79374001, "long" => 39.03445994],
            ["name" => "رفحاء", "lat" => 29.63723002, "long" => 43.49903001],
            ["name" =>  "الرس", "lat" => 25.87025999, "long" => 43.50747996],
            ["name" =>  "راس تنورة", "lat" => 26.70673998, "long" => 50.07245984],
            ["name" =>  "الرياض", "lat" => 24.774265, "long" => 46.738586],
            ["name" =>  "الرميلة", "lat" => 25.41251994, "long" => 49.7444199],
            ["name" =>  "سراة عبيدة", "lat" => 18.08422994, "long" => 43.14460004],
            ["name" => "سيهات", "lat" => 26.48341001, "long" => 50.04679975],
            ["name" =>  "مدينة صفوى", "lat" => 26.66339995, "long" => 49.9616098],
            ["name" =>  "سكاكا", "lat" => 29.953894, "long" => 40.197044],
            ["name" =>  "عرعر", "lat" => 30.983334, "long" => 41.016666],
            ["name" =>  "شرورة", "lat" => 17.4997518, "long" => 47.18864332],
            ["name" =>  "شقراء", "lat" => 25.24146004, "long" => 45.25506007],
            ["name" =>  "السليل", "lat" => 27.30328333, "long" => 42.25821667],
            ["name" => "الطائف", "lat" => 21.437273, "long" => 40.512714],
            ["name" => "تبوك", "lat" => 27.930120, "long" => 35.277328],
            ["name" =>  "تاروت", "lat" => 26.57110001, "long" => 50.07269982],
            ["name" => "تيماء", "lat" => 27.63502, "long" => 38.55060002],
            ["name" =>  "ثادق", "lat" => 25.29714995, "long" => 45.86178998],
            ["name" =>  "ثول", "lat" => 22.27165001, "long" => 39.10917999],
            ["name" =>  "الثقبة", "lat" => 26.25940996, "long" => 50.21558977],
            ["name" =>  "طريف", "lat" => 31.666078, "long" => 38.663469],
            ["name" => "طبرجل", "lat" => 30.515478, "long" => 38.221649],
            ["name" =>  "العضيلية", "lat" => 25.15497, "long" => 49.29419997],
            ["name" =>  "العلا", "lat" => 26.550264, "long" => 37.967865],
            ["name" =>  "أم الساهك", "lat" => 26.65903002, "long" => 49.92348988],
            ["name" =>  "عنيزة", "lat" => 26.09155002, "long" => 43.98767004],
            ["name" =>  "العيينة", "lat" => 26.81173997, "long" => 48.34168999],
            ["name" =>  "عيون الجواء", "lat" => 26.49974004, "long" => 43.62932997],
            ["name" => " وادي الدواسر", "lat" => 20.46967996, "long" => 44.78301002],
            ["name" =>  "الوجه", "lat" => 26.24021994, "long" => 36.47300001],
            ["name" => "ينبع", "lat" => 24.186848, "long" => 38.026428],
            ["name" => "الزلفي", "lat" => 26.29711002, "long" => 44.80577002],
        ];
        City::insert($cities);
    }
}