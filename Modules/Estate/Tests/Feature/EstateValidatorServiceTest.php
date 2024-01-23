<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Validation\ValidationException;
use Modules\Category\Database\Seeders\CategoryDatabaseSeeder;
use Modules\City\Database\Seeders\CityDatabaseSeeder;
use Modules\Estate\Database\Seeders\EstateAttributesTableSeeder;
use Modules\Estate\DataTransferObject\EstateDetailsDto;
use Modules\Estate\Services\EstateValidatorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

uses(Tests\TestCase::class);
uses(DatabaseMigrations::class);
beforeEach(function () {
    $json = '[
        {
            "attribute":1,
            "value":2
        },
        {
            "attribute":2,
            "value":2
        },
        {
            "attribute":3,
            "value":1
        },
        {
            "attribute":4,
            "value":4
        },{
            "attribute":5,
            "value":5
        },
        {
            "attribute":6,
            "value":7
        },
        {
            "attribute":7,
            "value":9
        }

    ]';
    $this->attributes = json_decode($json, true);
    $this->artisan('migrate:fresh --seed');
});
test('test_estate_service_will_not_return_error', function () {
    $dto = new EstateDetailsDto(1, $this->attributes);
    $service = new  EstateValidatorService($dto);
    $service->validate();
    $this->assertTrue(true);
})->group('estate');

test('test_estate_service_will_return_error_of_missing_attributes_exception', function () {
    unset($this->attributes[3]);
    $dto = new EstateDetailsDto(1, $this->attributes);
    $service = new  EstateValidatorService($dto);
    $service->validate();
    $this->expectException(ValidationException::class);
})
    ->group('estate')
    ->throws(ValidationException::class);
test('test_estate_service_will_throw_exception_with_predefined_invalid_user_values', function () {
    $this->attributes[3]['value'] = 10;
    $dto = new EstateDetailsDto(1, $this->attributes);
    $service = new  EstateValidatorService($dto);
    $service->validate();
    $this->expectException(ValidationException::class);
})->group('estate')
    ->throws(ValidationException::class);
test('test_estate_service_will_not_throw_exception_with_predefined_user_values', function () {
    $dto = new EstateDetailsDto(1, $this->attributes);
    $service = new  EstateValidatorService($dto);
    $service->validate();
    $this->assertTrue(true);
})->group('estate');
test('test_estate_service_will_throw_exception_with_invalid_input_values', function () {
    $this->attributes[1]['value'] = 'test';
    $dto = new EstateDetailsDto(1, $this->attributes);
    $service = new  EstateValidatorService($dto);
    $service->validate();
    $this->expectException(ValidationException::class);
})->group('estate')
    ->throws(ValidationException::class);
test('test_estate_service_will_not_throw_exception_with_input_values', function () {
    $this->attributes[1]['value'] = 50;
    $dto = new EstateDetailsDto(1, $this->attributes);
    $service = new  EstateValidatorService($dto);
    $service->validate();
    $this->assertTrue(true);
})->group('estate');