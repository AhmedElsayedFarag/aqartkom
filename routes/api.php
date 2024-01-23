<?php

use App\DataTransferObjects\CoordinateDto;
use App\DataTransferObjects\FCMDTO;
use App\Helpers\FCMHelper;
use App\Helpers\Geohash;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TakamolatController;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Modules\Auth\Entities\User;
use Modules\Estate\DataTransferObject\EstatableDto;
use Modules\Estate\DataTransferObject\EstateDto;
use Modules\Estate\Entities\Estate;
use Modules\Estate\Services\EstateService;
use Illuminate\Support\Str;
use Modules\Ad\Services\AdService;
use Modules\Category\Entities\FeaturedCategory;
use Modules\City\Entities\City;
use Modules\Setting\Services\SettingsService;
use Modules\Transaction\Services\PaymentService;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Route::post('insert-users', function (Request $request) {
//     DB::transaction(function () use ($request) {
//         $users = $request->users;
//         foreach ($users as $usr) {

//             $user = User::create(Arr::only($usr, [
//                 'name',
//                 'email',
//                 'phone',
//                 'password',
//                 'uuid',
//                 'type'
//             ]));
//             if ($usr['type'] == 'marketer')
//                 $user->marketerProfile->update($usr['profile']);
//             if ($usr['type'] == 'company') {
//                 // $user->assignRole('company');
//                 if ($usr['profile']['logo'] != '#') {
//                     $name = Str::uuid()->toString() . '.jpg';
//                     Storage::disk('companies')->put($name, file_get_contents("https://aqaratikom.com/" . $usr['profile']['logo']));
//                     $usr['profile']['logo'] = 'storage/companies/' . $name;
//                 } else
//                     $usr['profile']['logo'] = 'default/companies/1.png';

//                 $user->companyProfile->update($usr['profile']);
//             }
//         }
//     });
// });
Route::get('/v1/change-verification', function () {
    auth()->user()->is_authorized = !auth()->user()->is_authorized;
    auth()->user()->save();
})->middleware('auth:sanctum');
Route::get('/v1/home', HomeController::class);
Route::get('/v1/app-settings', function () {

    $formattedSettings = [];
    $settings = SettingsService::getAppSettings();
    foreach ($settings as $setting) {
        if ($setting['key'] == 'image' || $setting['key'] == 'app_popup')
            $formattedSettings[$setting['key']] = asset($setting['value']);
        else
            $formattedSettings[$setting['key']] = $setting['value'];
    }
    return response()->json([
        'data' => $formattedSettings,
    ]);
});
Route::get('/v1/commission-settings', function () {
    $formattedSettings = [];
    $settings = SettingsService::getCommissionSettings();
    foreach ($settings as $setting) {
        if ($setting['key'] == 'advertisement_rules') {
            $formattedSettings[$setting['key']] = json_decode($setting['value']);
        } else
            $formattedSettings[$setting['key']] = $setting['value'];
    }
    return response()->json([
        'data' => $formattedSettings,
    ]);
});
Route::get('/v1/ad-units', function () {
    return response()->json([
        'units' => [
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '10+'
        ]
    ]);
});
Route::get('/v1/get-payment-methods', function () {
    return response()->json([
        'methods' => Cache::remember('payment-methods', 36000, function () {
            $service = new PaymentService();
            return $service->initiate(10);
        }),
    ]);
});
Route::get('/v1/get-mortgages-features', function () {
    return response()->json([
        'age' => format_mortgages_features(__('mortgage.age')),
        'bank' => format_mortgages_features(__('mortgage.bank')),
        'group' => format_mortgages_features(__('mortgage.group')),
        'salary' => format_mortgages_features(__('mortgage.salary')),
        'area' => format_mortgages_features(__('mortgage.area')),

    ]);
});
// Route::get('/v1/indicators', function () {

//     return response()->json([
//         // 'url'=> "https://www.aqarsas.com/indicators",
//         'url' => "",
//     ]);
// });

// Route::post('v1/add-feature-category', function (Request $request) {
//     $image = upload_image($request->file('background'), 'categories');

//     $data = $request->only(['title', 'category_id', 'type']);
//     $cities = City::select(['id'])->get();
//     $formattedCategories = [];
//     foreach ($cities as $city) {
//         $formattedCategories[] = [
//             'title' => $data['title'],
//             'category_id' => $data['category_id'],
//             'type' => $data['type'],
//             'city_id' => $city->id,
//             'background' => $image
//         ];
//     }

//     FeaturedCategory::insert($formattedCategories);
// });

Route::get('/v1/ad-relations', function () {
    return response()->json([
        'data' => [
            [
                'type' => 'owner',
                'name' => 'مالك',
            ],
            [
                'type' => 'agent',
                'name' => 'وكيل',
            ],
            [
                'type' => 'marketer',
                'name' => 'مسوق',
            ],

        ]
    ]);
});

Route::post('/v1/check-estate', TakamolatController::class);
Route::post('/v1/send-notification', function () {
    request()->validate([
        'mobile_token' => 'required|string|min:3|max:255',
        'title' => 'required|string|min:3|max:255',
        'body' => 'required|string|min:3|max:255',
    ]);
    $dto = new FCMDTO(
        request()->get('title'),
        request()->get('body'),
        request()->get('mobile_token'),
    );
    return response()->json([
        'message' => FCMHelper::sendMessage($dto),
    ]);
});
Route::post('/v1/send-topic', function () {
    request()->validate([
        'title' => 'required|string|min:3|max:255',
        'body' => 'required|string|min:3|max:255',
        'topic' => 'required|string|min:3|max:255',
    ]);
    $dto = new FCMDTO(
        request()->get('title'),
        request()->get('body'),
        null,
        request()->get('topic'),
    );
    $dto = $dto->setType('topic');
    return response()->json([
        'message' => FCMHelper::sendTopic($dto),
    ]);
});

Route::get('test-geohash', function () {
    $service = new AdService();
    $firstPoint = new CoordinateDto();
    $secondPoint = new CoordinateDto();
    $service->getAdsByGeoHash($firstPoint, $secondPoint);
});