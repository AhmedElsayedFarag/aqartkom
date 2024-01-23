<?php

namespace Modules\Subscription\Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Modules\Auth\Entities\User;
use Modules\Subscription\Entities\Package;
use Modules\Subscription\Enums\SubscriptionStatusEnum;
use Modules\Subscription\Services\SubscriptionService;
use PDO;
use Tests\TestCase;

class SubscriptionServiceTest extends TestCase
{
    use DatabaseMigrations;


    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('module:migrate-fresh --seed');
    }

    public function test_subscribe_method_with_none_subscribed_user_returns_pending_subscription()
    {
        $user = User::factory()->create();
        $package = Package::first();
        $subscription = SubscriptionService::subscribe($user, $package);

        $this->assertEquals('pending', $subscription->status->value);
    }

    public function test_subscription_lasts_for_expected_period()
    {
        $user = User::factory()->create();
        $yearlyPackage = Package::whereType('yearly')->first();
        $yearlySubscription = SubscriptionService::subscribe($user, $yearlyPackage);
        $monthsCount = $yearlySubscription->end_at->diffInMonths(now());
        $this->assertEquals(11, $monthsCount);


        $anotherUser = User::factory()->create();
        $monthlyPackage = Package::whereType('monthly')->first();
        $monthlySubscription = SubscriptionService::subscribe($anotherUser, $monthlyPackage);
        $this->assertEquals(now()->addMonth(1)->format('Y-m-d'), $monthlySubscription->end_at->format('Y-m-d'));
    }

    public function test_subscribing_in_new_package_change_the_old_package_status_to_suspended()
    {
        $user = User::factory()->create();
        $package = Package::first();
        $subscription = SubscriptionService::subscribe($user, $package);
        SubscriptionService::changeState($subscription, SubscriptionStatusEnum::APPROVED);

        $anotherPackage = Package::whereNot('id', $package->id)->first();
        SubscriptionService::subscribe($user, $anotherPackage);
        $subscription->refresh();
        $this->assertEquals('suspended', $subscription->status);
    }
}
