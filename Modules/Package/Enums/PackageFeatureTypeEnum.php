<?php

namespace Modules\Package\Enums;

enum PackageFeatureTypeEnum: string
{
    case AdFeature = 'ad_feature';
    case AdvertisingLicense = 'advertising_license';
    case MarketingAdByAqaratikom = 'marketing_ad_by_aqaratikom'; // اضافة اعلان تسويقي من قبل عقاراتكم
    case MarketingAdByMarketer = 'marketing_ad_by_marketer'; // اضافة اعلان مرخص من قبل المسوق
    case NormalAds = 'normal_ads'; // اعلان عادي مرخص
    case UnlimitedNormalAds = 'unlimited_normal_ads'; // اعلان عادي مرخص
    case AdRequest = 'ad_request';
    case ContactMarketers = 'contact_marketers';
    case ContactMarketingRequests = 'marketing_requests';
}
