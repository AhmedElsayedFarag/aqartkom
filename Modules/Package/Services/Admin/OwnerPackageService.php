<?php

namespace Modules\Package\Services\Admin;

use Illuminate\Support\Facades\DB;
use Modules\Package\Entities\Package;
use Modules\Package\Enums\PackageFeatureTypeEnum;

class OwnerPackageService
{

    public function getAll()
    {
        return Package::type('owner')->paginate();
    }

    public function getUserPackage($userId)
    {
        return Package::type('owner')->paginate();
    }

    public function getAttributes()
    {
        return
            [
                [
                    'title' => __('features.ad_feature_count'),
                    'type' => PackageFeatureTypeEnum::AdFeature->value,
                ],
                [
                    'title' => __('features.marketing_request_by_aqaratikom'),
                    'type' => PackageFeatureTypeEnum::MarketingAdByAqaratikom->value,
                ],
                // [
                //     'title' => __('features.marketing_request_by_marketer'),
                //     'type' => PackageFeatureTypeEnum::MarketingAdByMarketer->value,
                // ],
                [
                    'title' => __('features.ads_count'),
                    'type' => PackageFeatureTypeEnum::NormalAds->value,
                ],
                // [
                //     'title' => __('features.ad_request_count'),
                //     'type' => PackageFeatureTypeEnum::AdRequest->value,
                // ],
                // [
                //     'title' => __('features.contact_marketers_count'),
                //     'type' => PackageFeatureTypeEnum::ContactMarketers->value,
                // ],
            ];
    }
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $package = Package::create([
                'title' => $data['title'],
                'price' => $data['price'],
                'months' => $data['months'],
                'user_type' => 'owner',
            ]);
            $this->addFeatures($package, $data);
            return $package;
        });
    }
    public function update(Package $package, array $data)
    {
        return DB::transaction(function () use ($package, $data) {
            $package->update([
                'title' => $data['title'],
                'price' => $data['price'],
                'months' => $data['months'],
            ]);
            $package->features()->delete();
            $this->addFeatures($package, $data);
            return $package;
        });
    }
    private function addFeatures(Package $package, array $features)
    {
        $formattedFeatures = [
            [
                'title' => __('features.ad_feature_count'),
                'type' => PackageFeatureTypeEnum::AdFeature->value,
                'value' => [
                    'count' => $features['ad_feature'],
                    'days' => $features['ad_feature_ads_count'],
                ],
            ],
            [
                'title' => __('features.marketing_request_by_aqaratikom'),
                'type' => PackageFeatureTypeEnum::MarketingAdByAqaratikom->value,
                'value' => [
                    'count' => $features['marketing_ad_by_aqaratikom'],
                ],
            ],
            [
                'title' => __('features.ads_count'),
                'type' => PackageFeatureTypeEnum::NormalAds->value,
                'value' => [
                    'count' => $features['normal_ads'],
                ],
            ],
        ];
        if ($features['unlimited_ads'] == 1) {
            $formattedFeatures[] = [
                'title' => __('features.unlimited_ads_count'),
                'type' => PackageFeatureTypeEnum::UnlimitedNormalAds->value,
                'value' => [
                    'count' => 0,
                ],
            ];
        } else {
            $formattedFeatures[] = [
                'title' => __('features.ads_count'),
                'type' => PackageFeatureTypeEnum::NormalAds->value,
                'value' => [
                    'count' => $features['normal_ads'],
                ],
            ];
        }

        $package->features()->createMany($formattedFeatures);
        cache()->forget('owner-packages');
    }
}