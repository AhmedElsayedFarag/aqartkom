<?php

namespace Modules\Subscription\Services\Features;

use App\Exceptions\PackageFeatureIsExpired;
use HasActiveSubscription;
use Modules\Subscription\Contracts\IActiveSubscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Ad\Services\AdService;
use Modules\Subscription\Contracts\IFeatureHandler;
use Modules\Subscription\Entities\SubscriptionFeature;
use Modules\Subscription\Services\SubscriptionService;
use Modules\Subscription\Services\UsageService;
use Modules\Subscription\Traits\HasActiveSubscription as TraitsHasActiveSubscription;

class AdFeatureHandler
{
    //add is from package or not
    public function handle(SubscriptionFeature $feature, ?Model $implemented = null)
    {
        return DB::transaction(function () use ($feature, $implemented) {
            //check on available remaining count
            if ($feature->remaining_count <= 0) {
                throw new PackageFeatureIsExpired();
            }
            $adService = new AdService();
            $adService->addFeature($implemented, $feature->feature_value['days']);

            $feature->remaining_count--;
            $feature->save();
            UsageService::create($feature->feature_type, $implemented, true);
            return true;
        });
    }
}