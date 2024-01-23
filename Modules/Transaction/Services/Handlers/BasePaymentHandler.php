<?php

namespace Modules\Transaction\Services\Handlers;

use Modules\Transaction\Enums\PaymentTypeEnum;

class BasePaymentHandler
{

    public static function make(PaymentTypeEnum $enum)
    {
        return match ($enum) {
            PaymentTypeEnum::AdFeature => new AdFeatureHandler(),
            PaymentTypeEnum::AdvertisingLicense => new AdLicensingHandler(),
            PaymentTypeEnum::Subscription => new SubscriptionHandler(),
            default => throw new \Exception('Invalid payment type')
        };
    }
}
