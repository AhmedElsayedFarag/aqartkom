<?php

namespace Modules\Transaction\Enums;

//create enum
enum PaymentTypeEnum: string
{
    case AdFeature = 'ad_feature';
    case AdvertisingLicense = 'advertising_license';
    case Subscription = 'subscription';
}