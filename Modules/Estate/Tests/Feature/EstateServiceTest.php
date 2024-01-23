<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Modules\Estate\DataTransferObject\EstateDto;
use Modules\Estate\Entities\EstateMedia;
use Modules\Estate\Services\EstateService;
use Modules\Media\DataTransferObject\MediaDto;
use Modules\Media\Entities\Media;
use Modules\Media\Services\LocalMediaService;
use Modules\Media\Services\MediaService;
use Illuminate\Foundation\Testing\DatabaseMigrations;

uses(Tests\TestCase::class);
// uses(DatabaseMigrations::class);
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

test('test_estate_is_created', function () {
    $service = new EstateService();
    $estateDto = new EstateDto(
        $this->data['estate'],
        $this->data['details'],
        $this->data['media'],
    );
    $estate =  $service->createOrUpdate($estateDto);
    $this->assertCount(1, DB::table('estates')->where('id', $estate->id)->get());
})->group('estate');
test('test_estate_is_updated', function () {
    $estateDto = new EstateDto(
        $this->data['estate'],
        $this->data['details'],
        $this->data['media'],
    );
    $service = new EstateService();
    $estate =  $service->createOrUpdate($estateDto);
    $this->data['estate']['title'] = 'Test Title';
    $this->data['details'][0]['value'] = 20;
    $this->data['details'][3]['value'] = 3;
    $estateDto = new EstateDto(
        $this->data['estate'],
        $this->data['details'],
        $this->data['media'],
    );
    $estate = $service->createOrUpdate($estateDto, $estate);
    $this->assertEquals('Test Title', $estate->title);
    $this->assertEquals(20, $estate->details->first()->value['value']);
    $this->assertEquals(9, $estate->details->last()->estate_attribute_value_id);
})->group('estate');
test('test_estate_media_is_moved', function () {
    $service = new EstateService();
    $estateDto = new EstateDto(
        $this->data['estate'],
        $this->data['details'],
        $this->data['media'],
    );
    $estate =  $service->createOrUpdate($estateDto);
    $this->assertCount(0, Media::whereIn('uuid', $this->media)->get());
    $this->assertCount(count($this->media), EstateMedia::where('estate_id', $estate->id)->get());
})->group('estate');
test('test_estate_is_building_category_attributes_is_required', function () {
    $this->expectException(ValidationException::class);
    $service = new EstateService();
    unset($this->data['estate']['age']);
    $estateDto = new EstateDto(
        $this->data['estate'],
        $this->data['details'],
        $this->data['media'],
    );
    $service->createOrUpdate($estateDto);
})
    ->throws(ValidationException::class)
    ->group('estate');