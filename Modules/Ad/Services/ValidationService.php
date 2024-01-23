<?php

namespace Modules\Ad\Services;

use App\Exceptions\NoChosenStepException;
use App\Exceptions\NoLicenseNumberProvidedException;
use Modules\Subscription\Services\SubscriptionService;

class ValidationService
{
    public static function validateAddingAds()
    {
        if (auth()->user()->type == 'company')
            return;
        if (auth()->user()->free_ads == 0) {
            SubscriptionService::checkHasActiveSubscription();
        }
    }
    public static function hasLicenseNumber()
    {
        if (!session()->has('license_number'))
            throw new NoLicenseNumberProvidedException();
    }
    public static function validateStep(string $key)
    {
        if (!session()->has('ad_type') || session('ad_type') != $key) {
            throw new NoChosenStepException();
        }
    }
}