<?php

namespace Modules\Subscription\Services\Features;

use App\Exceptions\NoActiveSubscriptionException;
use App\Exceptions\PackageFeatureIsExpired;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Ad\Services\AdService;
use Modules\Package\Enums\PackageFeatureTypeEnum;
use Modules\Subscription\Entities\SubscriptionFeature;
use Modules\Subscription\Services\SubscriptionService;
use Modules\Subscription\Services\UsageService;


class IncrementFeatureUsageHandler
{
    //add is from package or not
    public function handle(SubscriptionFeature $feature, ?Model $implemented = null)
    {
        return DB::transaction(function () use ($feature, $implemented) {
            //check on available remaining count
            if ($feature->feature_type != PackageFeatureTypeEnum::UnlimitedNormalAds) {

                if ($feature->remaining_count <= 0) {
                    throw new PackageFeatureIsExpired();
                }

                $feature->remaining_count--;
                $feature->save();
            }
            UsageService::create($feature->feature_type, $implemented, true);
            return true;
        });
    }
}
