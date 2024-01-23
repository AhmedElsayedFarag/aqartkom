<?php

use App\DataTransferObjects\CoordinateDto;
use App\DataTransferObjects\FCMDTO;
use App\DataTransferObjects\QrcodeDto;
use App\Events\AdminNotification;
use App\Events\VerifyEvent;
use App\Helpers\FCMHelper;
use App\Helpers\Geohash;
use App\Helpers\PriceFormatter;
use App\Http\Controllers\DarkModeController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\LoginNafathController;
use App\Models\Nafath;
use App\Notifications\AdIsAcceptedNotification;
use App\Services\MsegatService;
use App\Services\NafathService;
use App\Services\TakamolatService;
use Faker\Provider\ar_EG\Payment;
use Google\Service\Calendar\Setting;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Modules\Ad\Entities\Ad;
use Modules\Ad\Entities\AdType;
use Modules\Ad\Services\AdService;
use Modules\Auction\Entities\Auction;
use Modules\Auth\Entities\User;
use Modules\BotQuestion\Entities\BotQuestion;
use Modules\Category\Entities\FeaturedCategory;
use Modules\City\Entities\City;
use Modules\Estate\Entities\Estate;
use Modules\Estate\Entities\EstateAttribute;
use Modules\Estate\Entities\EstateMedia;
use Modules\Neighborhood\Entities\Neighborhood;
use Modules\SEO\Entities\SEO;
use Modules\SEO\Services\SeoService;
use Modules\Setting\Entities\Settings;
use Modules\Setting\Services\SettingsService;
use Modules\Transaction\DTO\PaymentDTO;
use Modules\Transaction\Enums\PaymentTypeEnum;
use Modules\Transaction\Services\PaymentService;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('change-users-roles', function () {
//     User::where('type', 'customer')->update(['type' => 'owner']);
//     User::role('customer')->get()->each(function ($user) {
//         $user->removeRole('customer');
//         $user->assignRole('owner');
//     });
// });
// Route::get('ad-types', function () {
//     AdType::insert([
//         [
//             'name' => 'بيع',
//             'type' => 'sell',
//         ],
//         [
//             'name' => 'يومي',
//             'type' => 'rent',
//         ],
//         [
//             'name' => 'شهري',
//             'type' => 'rent',
//         ],
//         [
//             'name' => 'سنوي',
//             'type' => 'rent',
//         ],
//     ]);
// });
// Route::get('add-ad-type', function () {
//     DB::table('ads')->where('type', 'sell')->update(['ad_type_id' => 1]);
//     DB::table('ads')->where('type', 'rent')->update(['ad_type_id' => 4]);
// });
// Route::get('qr-code', function () {
//     dd(create_qr_code('bac3812a-c58c-4ac4-8de5-32b62cb22656'));
// });
// Route::get('insert-bot-questions', function () {
//     BotQuestion::insert([
//         [
//             'question' => 'ماذا ترغب ان توفر لك منصة عقاراتكم ؟',
//             'type' => 'select',
//             'content' => 'type'
//         ],
//         [
//             'question' => 'ما العقار الذي تريد البحث عنه ؟',
//             'type' => 'select',
//             'content' => 'category'
//         ],
//         [
//             'question' => 'ما المدينة التي ان ترغب ان تسكن فيها ؟',
//             'type' => 'text',
//             'content' => 'city'
//         ],
//         [
//             'question' => 'ما هي واجهة المدينة التي ترغب ان تسكن فيها ؟',
//             'type' => 'select',
//             'content' => 'neighborhood'
//         ],
//     ]);
// });
// Route::get('test', function () {
//     $cities = City::select(['id', 'name'])->get();
//     $featuredCategories = [];
//     $neighborhoods = [];
//     foreach ($cities as $city) {
//         $neighborhoods[] = [
//             'city_id' => $city->id,
//             'name' => 'شمال ' . $city->name,
//         ];
//         $neighborhoods[] = [
//             'city_id' => $city->id,
//             'name' => 'شرق ' . $city->name,
//         ];
//         $neighborhoods[] = [
//             'city_id' => $city->id,
//             'name' => 'غرب ' . $city->name,
//         ];
//         $neighborhoods[] = [
//             'city_id' => $city->id,
//             'name' => 'جنوب ' . $city->name,
//         ];
//         $neighborhoods[] = [
//             'city_id' => $city->id,
//             'name' => 'وسط ' . $city->name,
//         ];
//         $featuredCategories[] = [
//             'title' => 'فلل للبيع',
//             'city_id' => $city->id,
//             'category_id' => 1,
//             'background' => 'default/categories/1.png',
//             'type' => 'sell'
//         ];
//         $featuredCategories[] = [
//             'title' => 'شقق للبيع',
//             'city_id' => $city->id,
//             'category_id' => 2,
//             'background' => 'default/categories/2.png',
//             'type' => 'sell'
//         ];
//         $featuredCategories[] = [
//             'title' => 'استراحات للبيع',
//             'city_id' => $city->id,
//             'category_id' => 6,
//             'background' => 'default/categories/3.png',
//             'type' => 'sell'
//         ];
//         $featuredCategories[] = [
//             'title' => 'فلل للبيع',
//             'city_id' => $city->id,
//             'category_id' => 8,
//             'background' => 'default/categories/4.png',
//             'type' => 'sell'
//         ];
//     }
//     DB::table('neighborhoods')->insert($neighborhoods);
//     DB::table('featured_categories')->insert($featuredCategories);
//     // Estate::select(['id'])->with(['media'])->chunk(100, function ($estates) {
//     //     $formattedImages = [];
//     //     foreach ($estates as $estate) {
//     //         $imageCover = (array)$estate->media->where('type', 'image')->first();

//     //         $formattedImages[] = [
//     //             ...$imageCover["\x00*\x00attributes"],
//     //             'is_cover' => true
//     //         ];
//     //     }
//     //     // dd($formattedImages);
//     //     DB::table('estate_media')->upsert($formattedImages, ['id'], ['is_cover']);
//     // });

// });

// Route::get('seed', function () {

//     SEO::insert([
//         [
//             'key' => 'og:title',
//             'value' => 'عقارتكم',
//             'type' => 'string'
//         ],
//         [
//             'key' => 'title',
//             'value' => 'عقارتكم',
//             'type' => 'string'
//         ],
//         [
//             'key' => 'og:type',
//             'value' => 'article',
//             'type' => 'string'
//         ],
//         [
//             'key' => 'og:url',
//             'value' => route('front.index'),
//             'type' => 'string'
//         ],
//         [
//             'key' => 'og:description',
//             'value' => 'عقارتكم',
//             'type' => 'string'
//         ],
//         [
//             'key' => 'og:image:alt',
//             'value' => 'عقارتكم',
//             'type' => 'string'
//         ],
//         // [
//         //     'key' => 'og:image',
//         //     'value' => asset('front-end/images/mzad.png'),
//         //     'type' => 'image'
//         // ],
//         [
//             'key' => 'og:site_name',
//             'value' => 'عقارتكم',
//             'type' => 'string'
//         ],
//         [
//             'key' => 'og:locale',
//             'value' => 'ar',
//             'type' => 'string'
//         ],
//         [
//             'key' => 'article:author',
//             'value' => 'عقارتكم',
//             'type' => 'string'
//         ],
//         [
//             'key' => 'twitter:card',
//             'value' => 'summary_large_image',
//             'type' => 'string'
//         ],
//         [
//             'key' => 'twitter:site',
//             'value' => '@AqaratikomA',
//             'type' => 'string'
//         ],
//         [
//             'key' => 'twitter:creator',
//             'value' => '@AqaratikomA',
//             'type' => 'string'
//         ],
//         [
//             'key' => 'twitter:url',
//             'value' => route('front.index'),
//             'type' => 'string'
//         ],
//         [
//             'key' => 'twitter:title',
//             'value' => 'عقارتكم',
//             'type' => 'string'
//         ],
//         [
//             'key' => 'twitter:description',
//             'value' => 'عقارتكم',
//             'type' => 'string'
//         ],
//         // [
//         //     'key' => 'twitter:image',
//         //     'value' => asset('front-end/images/mzad.png'),
//         //     'type' => 'image'
//         // ],
//         [
//             'key' => 'twitter:image:alt',
//             'value' => 'عقارتكم',
//             'type' => 'string'
//         ],
//     ]);
// });
Route::get('dark-mode-switcher', [DarkModeController::class, 'switch'])->name('dark-mode-switcher');
Route::view('map', 'front-end.map');
Route::get('/.well-known/assetlinks.json', function () {
    return [[
        "relation" => ["delegate_permission/common.handle_all_urls"],
        "target" => [
            "namespace" => "android_app",
            "package_name" => "com.fivegfordesign.aqaratikom",
            "sha256_cert_fingerprints" => ["F6:46:45:5D:BD:D0:67:CA:D9:8D:ED:CF:50:92:52:31:A6:B2:7C:13:6E:B5:26:01:EF:07:14:D6:3D:A8:AD:CE"]
        ]
    ]];
});
Route::get('/.well-known/apple-app-site-association', function () {
    return [
        "applinks" => [
            "apps" => [],
            "details" => [
                [
                    "appID" => "CAD8L7SA8G.com.fivegfordesign.aqaratikom",
                    "paths" => [
                        "/*"
                    ]
                ]
            ]
        ]
    ];
});

Route::get('/', [FrontEndController::class, 'home'])->name('front.index');
Route::get('/page/{page}', [FrontEndController::class, 'policy'])->name('front.policy');
Route::view('landing-social', 'social');

Route::get('update-marketers', function () {
    $marketers = User::role('marketer')->get();
    foreach ($marketers as $marketer) {
        $marketer->marketerProfile()->update([
            'qr_code' => create_qr_code(
                new QrcodeDto(
                    route('front.marketer.show', ['marketer' => $marketer->uuid]),
                    'marketers'
                )
            )
        ]);
    }
});

// Route::get('update-settings', function () {
//     Settings::create([
//         'key' => 'advertisement_commission',
//         'value' => 2.5,
//         'group' => 'advertisement',
//     ]);
//     Settings::create([
//         'key' => 'advertisement_rules',
//         'value' => json_encode([
//             'يتم ارسال فريق تصوير متخصص من قبل منصات عقارتكم لتصوير العقار وعرض جميع تفاصيل العقار',
//             'تصميم فيديو احترافي مع تسجيل صوتي لترويج العقار علي منصات السوشيال ميديا',
//             'أضافة صور العقار وتفاصيل علي العقار علي منصات السوشيال ميديا (تطبيق عقارتكم - الانستجرام - تويتر - سناب شات )',
//             'إطلاق حملات إعلانية ممولة للعقار علي جوجل ادز ومنصات التواصل الاجتماعي',
//             'الرد علي استفسارات العملاء بخصوص العقار من قبل فريق مبيعات عقارتكم',
//             'ارسال مندوب مع المشتري لمعاينة موقع العقار'
//         ]),
//         'group' => 'advertisement'
//     ]);
// });

// Route::get("add-bot-question", function () {
//     BotQuestion::create([
//         'question',
//         'type',
//         'content',
//     ]);
// });

// Route::get('change-pass', function () {
//     dd(bcrypt('12345678'));
// });
// Route::get('test-media', function () {
//     EstateMedia::query()->chunk(500, function ($media) {
//         $missingFiles = [];
//         foreach ($media as $m) {

//             if (!File::exists(\public_path($m->url))) {
//                 $missingFiles[] = $m->url;
//             }
//         }
//         if (count($missingFiles)) {
//             File::append(storage_path('app/public/missing_files.txt'), implode("\n", $missingFiles));
//         }
//     });
// });

Route::get('test-payment', function () {
    $service = new PaymentService();
    dd($service->initiate(100));
    $dto = new PaymentDTO(
        paymentType: PaymentTypeEnum::AdFeature,
        customerName: 'test',
        customerPhone: '+966555555555',
        amount: 100,
        model: Ad::first(),
        paymentMethodId: 6,
    );
    dd($service->createLink($dto));
});
// Route::get('insert-settings', function () {
//     Settings::insert([
//         // [
//         //     'key' => "ad-feature-price",
//         //     'value' => "100",
//         //     'group' => "ad_feature",
//         // ],
//         // [
//         //     'key' => "ad-feature-time",
//         //     'value' => "10",
//         //     'group' => "ad_feature",
//         // ],
//         [
//             'key' => "ad-license-price",
//             'value' => "50",
//             'group' => "ad_license",
//         ],
//         [
//             'key' => "ad-license-marketer-price",
//             'value' => "50",
//             'group' => "ad_license",
//         ],
//         [
//             'key' => "ad-license-company-price",
//             'value' => "50",
//             'group' => "ad_license",
//         ],
//         [
//             'key' => "ads-count",
//             'value' => "3",
//             'group' => "free_package",
//         ],

//     ]);
//     DB::table('users')->update(['free_ads' => 3]);
//     DB::table('users')->where('type', 'customer')->update(['type' => 'owner']);
// });

Route::view('delete-user', 'front-end.delete-user')->name('delete-user.show');
Route::get('suggestions', [FrontEndController::class, 'showSuggestionsForm'])->name('suggestions.show');
Route::post('suggestions', [FrontEndController::class, 'storeSuggestions'])->name('suggestions.store');



// Route::get('takamolat', function () {
//     // dd(TakamolatService::createRequest(request()->licenceNumber , request()->advertiserId));

//     return true;
// });

Route::get('payment', function () {
    return '';
})->name('payment');

Route::any('nafath-callback', function () {

    if (is_null(request()->get('requestId')) || is_null(request()->get('transId')))
        return;
    NafathService::checkStatus(request()->get('requestId'), request()->get('transId'));
});

// Route::get('insert-permission', function () {
//     DB::table('permissions')->insert([
//         [
//             'name' => 'manage-mortgages',
//             'guard_name' => 'web',
//             'created_at' => now(),
//             'updated_at' => now(),
//         ],
//     ]);
// });

// Route::get('/insert-new-settings', function () {
//     Settings::insert(
//         [
//             'key' => "app_popup",
//             'value' => "default/popup.png",
//             'group' => "app",
//         ],
//     );
// });
// Route::get('/insert-new-settings1', function () {
//     Settings::insert(
//         [
//             'key' => "app_popup_link",
//             'value' => "",
//             'group' => "app",
//         ],
//     );
// });

// Route::get('test-fcm', function () {
//     $dto = new FCMDTO('تم دخول حسابك بنجاح', 'تم دخول حسابك بنجاح',  'd89IftoPTt-5QVpI9IZyi_:APA91bHZKXDx7_-pfOSV29UesCjmgt5jWOTXz8ATvwqtBUC-qUFTvNlcOHjBQHzEK3qvAXoMWUowSvY9PNDprijsJMiZexTDVEZKhE5cO7RfeNoJdL1XnwQqNN07Ku12LUPcD01gr2Mq');
//     $dto->addData('login', 'login')
//         ->addData('token', '49848|a77X75xsYMu7Er8ICtmku9zDh48mTcV2TO7bKV88')
//         ->addData('user_type', 'marketer')
//         ->isHidden();
//     dd(FCMHelper::sendMessage($dto));
// });

Route::get('login-nafath', LoginNafathController::class)->name('nafath-login');
// Route::get('test-takamalot', function () {
//     TakamolatService::createRequest('7100000031', '1034758704', 1);
// });


Route::get('add-geohas', function () {
    $estates = Estate::select(['id', 'lat', 'long'])->get();
    foreach ($estates as $estate) {
        $estate->update([
            'geo_hash' => Geohash::encode($estate->lat, $estate->long, 12),
        ]);
    }
});
Route::get('/upload-files', function () {
    $estates = Estate::select(['id'])->with(['media'])->latest()->limit(10)->get();
    foreach ($estates as $estate) {
        $estate->media->each(function ($media) {

            $media->update([
                'new_url' => Storage::disk('s3')->putFile('estates', new \Illuminate\Http\File(public_path($media->url)))
            ]);
            dump(Storage::disk("s3")->url($media->new_url));
        });
    }
});
// Route::get('push-admin-notification', function () {
//     event(new AdminNotification('test'));
// });

// Route::get('/insert-settings', function () {
//     Settings::insert([
//         [
//             'key' => "ads-marketer-count",
//             'value' => "5",
//             'group' => "free_package",
//         ],
//         [
//             'key' => "ads-company-count",
//             'value' => "8",
//             'group' => "free_package",
//         ],
//     ]);
// });