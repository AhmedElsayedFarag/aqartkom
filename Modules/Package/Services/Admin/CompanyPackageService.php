<?php

namespace Modules\Package\Services\Admin;

use Illuminate\Support\Facades\DB;
use Modules\Package\Entities\Package;
use Modules\Package\Enums\PackageFeatureTypeEnum;

class CompanyPackageService
{

    public function getAll()
    {
        return Package::type('company')->paginate();
    }
    public function getAttributes()
    {
        return
            [
                [
                    'title' => __('features.ad_feature_count'),
                    'type' => PackageFeatureTypeEnum::AdFeature->value,
                ],
                // [
                //     'title' => __('features.unlimited_ads_count'),
                //     'type' => PackageFeatureTypeEnum::UnlimitedNormalAds->value,
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
                'user_type' => 'company',
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
        $package->features()->createMany([
            [
                'title' => __('features.ad_feature_count'),
                'type' => PackageFeatureTypeEnum::AdFeature->value,
                'value' => [
                    'count' => $features['ad_feature'],
                    'days' => $features['ad_feature_ads_count'],
                ],
            ],
            [
                'title' => __('features.unlimited_ads_count'),
                'type' => PackageFeatureTypeEnum::UnlimitedNormalAds->value,
                'value' => [
                    'count' => 0,
                ],
            ],

        ]);
        cache()->forget('company-packages');
    }
}