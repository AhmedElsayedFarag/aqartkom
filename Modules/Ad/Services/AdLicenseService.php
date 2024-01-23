<?php

namespace Modules\Ad\Services;

use App\Events\AdminNotification;
use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Ad\Actions\CreateAdLicense;
use Modules\Ad\DataTransferObject\AdDto;
use Modules\Ad\Entities\Ad;
use Modules\Ad\Traits\BaseUserAdQuery;
use Modules\Estate\DataTransferObject\EstateDto;
use Modules\Estate\Services\EstateService;
use Modules\Package\Enums\PackageFeatureTypeEnum;
use Modules\Subscription\Services\Features\IncrementFeatureUsageHandler;
use Modules\Subscription\Services\SubscriptionService;

class AdLicenseService
{
    use BaseUserAdQuery;
    public function createOrUpdate(AdDto $adDto, EstateDto $estateDto, ?Ad $ad = null): ?Ad
    {
        $ad =  DB::transaction(function () use (&$ad, $estateDto, $adDto) {
            $estateService = new EstateService();
            if (is_null($ad)) {
                $license = (new CreateAdLicense)->handle($adDto, $estateDto);
                event(new AdminNotification(__('messages.new_license_request_is_added', ['name' => $adDto->getOwner()->name])));
                return $license;
            } else {
                $estate = $estateService->createOrUpdate($estateDto, $ad->estate);
                $adDto->setEstateID($estate->id);
                $ad->update([
                    ...$adDto->toArray(),
                    // 'status' => 'pending',
                    // 'accepted_at' => null,
                ]);
                return $ad;
            }
        });

        (new AdService)->loadRelations($ad);
        return $ad;
    }
    public function getUserLicense(int $userID, string $status)
    {
        return
            $this->baseUserAdQuery()
            ->where('is_license_request', true)
            ->normalAd()
            ->owner($userID)
            ->licenseStatus($status)
            ->status('approved')
            ->orderByDesc('ads.id')->paginate(15);
    }
}