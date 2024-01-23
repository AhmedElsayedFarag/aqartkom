<?php

namespace Modules\Auth\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Auth\Entities\User;
use Illuminate\Support\Str;
use Tests\TestCase;


class RegisteredUserControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('module:migrate-fresh --seed');
    }

    public function test_phone_number_is_unique()
    {
        User::factory()->create(['phone' => '+966541515113']);

        $this->postJson(
            'api/v1/auth/register',
            [
                'name' => 'john doe',
                'phone' => '+966541515113',
                'password' => 'password',
                'password_confirmation' => 'password',
                'type' => 'customer',
                'mobile_token' => Str::random(60)
            ]
        )->assertStatus(422);
    }

    public function test_register_data_is_valid()
    {
        $this->postJson(
            'api/v1/auth/register',
            [
                'name' => 'john doe',
                'phone' => '+9665415113',
                'password' => 'pa$sword',
                'password_confirmation' => '',
                'type' => 'customer',
                'mobile_token' => Str::random(60)
            ]
        )->assertStatus(422);
    }

    public function test_user_data_is_returned_after_register()
    {
        $this->postJson(
            'api/v1/auth/register',
            [
                'name' => 'john doe',
                'phone' => '+966541515223',
                'email' => 'test@mail.com',
                'password' => 'Pa$sword1',
                'password_confirmation' => 'Pa$sword1',
                'type' => 'customer',
                'otp' => 12324,
                'mobile_token' => Str::random(60)
            ]
        )->assertJson(
            fn (AssertableJson $json) =>
            $json->hasAll([
                'uuid',
                'name',
                'email',
                'phone',

                'token',
                'created_at',
                'updated_at',
            ])
        );
    }
}
