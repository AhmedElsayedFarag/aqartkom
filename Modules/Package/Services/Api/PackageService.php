<?php

namespace Modules\Package\Services\Api;

use Illuminate\Support\Facades\Cache;
use Modules\Package\Entities\Package;

class PackageService
{
    public function __construct()
    {
    }
    public static function getAll(string $type)
    {
        // return Cache::rememberForever($type . '-packages', function () use ($type) {
            return Package::type($type)->with(['features'])->get();
        // });
    }
    public static function formatFeatures($features)
    {
        return $features->map(function ($feature) {
            if ($feature->type->value == 'ad_feature')
                return __('features.formatting', ['ads' => get_arabic_number($feature->value['count']), 'days' => get_arabic_number($feature->value['days'])])[$feature->type->value];
            return __('features.formatting', ['count' => get_arabic_number($feature->value['count'])])[$feature->type->value];
        });
    }
}