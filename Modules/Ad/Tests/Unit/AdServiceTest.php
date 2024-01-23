<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Ad\DataTransferObject\AdDto;
use Modules\Ad\Entities\Ad;
use Modules\Ad\Enums\AdTypeEnum;
use Modules\Ad\Services\AdService;
use Modules\Auth\Entities\User;
use Modules\Estate\DataTransferObject\EstateDto;
use Modules\Media\DataTransferObject\MediaDto;
use Modules\Media\Services\LocalMediaService;
use Modules\Media\Services\MediaService;

uses(Tests\TestCase::class);
beforeEach(function () {
    Storage::fake('media');
    $images = [
        UploadedFile::fake()->image('image1.png'),
        UploadedFile::fake()->image('image2.png'),
        UploadedFile::fake()->image('image3.png')
    ];
    $this->media = [];
    $mediaService = new MediaService(new LocalMediaService());
    foreach ($images as $image) {
        $mediaDto = new MediaDto($image, 'media');
        $this->media[] = $mediaService->create($mediaDto)->uuid;
    }
    $this->data = [
        "estate" => [
            "city" => 1,
            "category" => 1,
            "neighborhood" => 1,
            "title" => "test",
            "description" => "nsddjh jasdhkjadkahjsjksadha",
            "area" => 1000,
            "age" => 1,
            'address' => 'Riyad',
            "is_furniture" => true,
            "bedroom" => 4,
            "lat" => 32.93893,
            "long" => 32.93893
        ],
        "media" => $this->media,
        'details' => [
            [
                "attribute" => 1,
                "value" => 2
            ],
            [
                "attribute" => 2,
                "value" => 2
            ],
            [
                "attribute" => 3,
                "value" => 1
            ],
            [
                "attribute" => 4,
                "value" => 4
            ],
            [
                "attribute" => 5,
                "value" => 5
            ],
            [
                "attribute" => 6,
                "value" => 7
            ],
            [
                "attribute" => 7,
                "value" => 9
            ]

        ]
    ];
    // $this->artisan('migrate:fresh --seed');
});
test('test_ad_can_be_created', function () {
    $adDto = new AdDto(
        'sell',
        '10000000',
        1,
    );
    $estateDto = new EstateDto(
        $this->data['estate'],
        $this->data['details'],
        $this->data['media'],
    );
    $adService = new AdService();
    $ad = $adService->createOrUpdate($adDto, $estateDto);
    $this->assertCount(1, Ad::where('id', $ad->id)->where('user_id', 1)->get());
    $this->assertEquals('10000000', $ad->price);
    $this->assertEquals(AdTypeEnum::SELL, $ad->type);
})->group('ad');

test('test_can_be_updated', function () {
    $ad = Ad::first();
    $adDto = new AdDto(
        'rent',
        '435345363634',
        1,
    );
    $this->data['estate']['title'] = 'Aqar1234';
    $estateDto = new EstateDto(
        $this->data['estate'],
        $this->data['details'],
        $this->data['media'],
    );
    $adService = new AdService();
    $ad = $adService->createOrUpdate($adDto, $estateDto, $ad);
    $this->assertCount(1, Ad::where('id', $ad->id)->where('user_id', 1)->get());
    $this->assertEquals('435345363634', $ad->price);
    $this->assertEquals(AdTypeEnum::RENT, $ad->type);
    $this->assertEquals('Aqar1234', $ad->estate->title);
})->group('ad');

test('test_pending_ads_is_returned', function () {
    $response = $this->actingAs(User::first())
        ->get('/api/v1/user/ad?status=pending');
    $pendingAds = Ad::where('status', 'pending')
        ->where('user_id', 1)
        ->count();
    $this->assertEquals($pendingAds, $response->getData()->meta->total);
})->group('ad');

test('test_approved_ads_is_returned', function () {
    $response = $this->actingAs(User::first())
        ->get('/api/v1/user/ad?status=approved');
    $approvedAds = Ad::where('status', 'approved')
        ->where('user_id', 1)
        ->count();
    $this->assertEquals($approvedAds, $response->getData()->meta->total);
})->group('ad');

test('test_closed_ads_is_returned', function () {
    $response = $this->actingAs(User::first())
        ->get('/api/v1/user/ad?status=closed');
    $closedAds = Ad::where('status', 'closed')
        ->where('user_id', 1)
        ->count();
    $this->assertEquals($closedAds, $response->getData()->meta->total);
})->group('ad');