<?php

namespace Modules\Ad\Actions;

use Exception;
use Modules\Ad\DataTransferObject\AdDto;
use Modules\Ad\Entities\Ad;
use Modules\Estate\DataTransferObject\EstateDto;
use Modules\Estate\Services\EstateService;
use Modules\Package\Enums\PackageFeatureTypeEnum;
use Modules\Subscription\Services\Features\IncrementFeatureUsageHandler;
use Modules\Subscription\Services\SubscriptionService;

class CreateAdLicense
{
    public function handle(AdDto $adDto, EstateDto $estateDto)
    {
        $estateService = new EstateService();
        $feature = null;
        //if doesn't have we will make payment link for that
        $status = 'approved';
        $activeSubscription = SubscriptionService::getActiveSubscription();
        if (is_null($activeSubscription)) {
            $status = 'pending';
        }
        $estate = $estateService->createOrUpdate($estateDto);
        $adDto->setEstateID($estate->id);
        $ad = Ad::create(
            [
                // 'is_dependable' => true,
                'accepted_at' => now(),
                'status' => $status,
                'is_license_request' => true,
                ...$adDto->toArray()
            ]
        );
        if ($status == 'approved' && $adDto->getOwner()->type != 'company') {
            $feature = $activeSubscription->getFeature(PackageFeatureTypeEnum::MarketingAdByAqaratikom);
            $handler = new IncrementFeatureUsageHandler();
            try {
                $handler->handle($feature, $ad);
            } catch (Exception $e) {
                $ad->update(['status' => 'pending']);
            }
        }
        $ad->views = 0;
        return $ad;
    }
}