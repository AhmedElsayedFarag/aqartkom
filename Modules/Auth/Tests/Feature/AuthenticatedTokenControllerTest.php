<?php

namespace Modules\Auth\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Modules\Auth\Entities\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;


class AuthenticatedTokenControllerTest extends TestCase
{
    use DatabaseMigrations;


    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('module:migrate-fresh --seed');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_authenticate_user_with_correct_credentials()
    {
        $user = User::factory()->create();

        $this->postJson(
            'api/v1/auth/login',

            ['phone' => $user->phone, 'password' => 'password', 'mobile_token' => $user->mobile_token]
        )->assertJson(['token' => true]);
    }

    public function test_user_cannot_login_if_blocked()
    {
        $user = User::factory()->create(['is_blocked' => true]);

        Sanctum::actingAs($user);

        $this->postJson(
            'api/v1/auth/ping',
        )->assertStatus(403);
    }
}
