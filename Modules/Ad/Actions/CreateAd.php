<?php

namespace Modules\Ad\Actions;

use App\Events\AdminNotification;
use Modules\Ad\DataTransferObject\AdDto;
use Modules\Ad\Entities\Ad;
use Modules\Estate\DataTransferObject\EstateDto;
use Modules\Estate\Services\EstateService;
use Modules\Package\Enums\PackageFeatureTypeEnum;
use Modules\Subscription\Services\Features\IncrementFeatureUsageHandler;
use Modules\Subscription\Services\SubscriptionService;

class CreateAd
{

    public function handle(AdDto $adDto, EstateDto $estateDto)
    {
        $owner = $adDto->getOwner();
        $estateService = new EstateService();
        if (auth()->user()->free_ads == 0) {
            SubscriptionService::checkHasActiveSubscription();
        }
        $estate = $estateService->createOrUpdate($estateDto);
        $adDto->setEstateID($estate->id);
        $ad = Ad::create(
            [
                // 'is_dependable' => true,
                'accepted_at' => now(),
                'status' => 'approved',
                'is_licensed' => true,
                'is_request' => false,
                // 'is_license_request' => $is_license_request == true ? 1 : 0,
                ...$adDto->toArray()
            ]
        );
        // $ad->status = 'pending';
        $ad->views = 0;
        if ($owner->free_ads != 0) {
            $owner->free_ads--;
            $owner->save();
            return $ad;
        }
        $activeSubscription = SubscriptionService::getActiveSubscription();
        $allowedFeatureTypes = [
            PackageFeatureTypeEnum::UnlimitedNormalAds,
            PackageFeatureTypeEnum::NormalAds,
        ];
        $feature = $activeSubscription->searchInMultipleFeature($allowedFeatureTypes);
        $handler = new IncrementFeatureUsageHandler();
        $handler->handle($feature, $ad);
        event(new AdminNotification(__('messages.new_ad_is_added', ['name' => $adDto->getOwner()->name])));


        return $ad;
    }
}