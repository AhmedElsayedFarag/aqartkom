<?php

namespace Modules\Users\Http\Controllers\Api;

use App\Helpers\JsonResponseMessages;
use Modules\Auth\Services\AuthService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Ad\Services\AdService;
use Modules\Auth\Entities\MarketerProfile;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Requests\Api\CompanyRequest;
use Modules\Auth\Http\Requests\Api\MarketersFilterRequest;
use Modules\Auth\Transformers\AuthUserResource;
use Modules\Auth\Http\Requests\Api\RegisterRequest;
use Modules\Auth\Http\Requests\Api\UpdateCompanyRequest;
use Modules\Auth\Services\CompanyProfileService;
use Modules\Users\Transformers\CompanyShowResource;
use Modules\Ad\Transformers\AdsResource;
use Modules\Auth\Services\MarketerProfileService;
use Modules\Auth\Transformers\MarketerShowResource;
use Modules\Auth\Transformers\MarketersResource;
use Modules\Package\Enums\PackageFeatureTypeEnum;
use Modules\Subscription\Entities\MarketerContact;
use Modules\Subscription\Services\Features\IncrementFeatureUsageHandler;
use Modules\Subscription\Services\SubscriptionService;
use Modules\Users\Transformers\MarketerContactResource;

class MarketersController extends Controller
{

    public function show(User $marketer)
    {
        return new MarketerShowResource($marketer);
    }
    public function index(MarketersFilterRequest $request)
    {
        return MarketersResource::collection(MarketerProfileService::getAll($request));
    }
    public function contact(User $marketer)
    {
        $marketerContact = MarketerContact::query()->where('customer_id', auth()->id())->where('marketer_id', $marketer->id)->first();
        if (!is_null($marketerContact)) {
            return new MarketerContactResource($marketerContact);
        }
        return DB::transaction(function () use ($marketer) {
            SubscriptionService::checkHasActiveSubscription();
            $activeSubscription = SubscriptionService::getActiveSubscription();
            $feature = $activeSubscription->getFeature(PackageFeatureTypeEnum::ContactMarketers);
            $handler = new IncrementFeatureUsageHandler();
            $handler->handle($feature, $marketer);
            $marketerContact = MarketerContact::create([
                'customer_id' => auth()->id(),
                'marketer_id' => request()->marketer->id,
                'customer_name' => auth()->user()->name,
                'customer_phone' => auth()->user()->phone,
                'marketer_phone' => $marketer->phone,
                'marketer_whatsapp' => $marketer->marketerProfile->whatsapp_number,
            ]);
            return new MarketerContactResource($marketerContact);
        });
    }
    public function ads(User $marketer)
    {
        abort_if($marketer->type !== 'marketer', Response::HTTP_NOT_FOUND);

        $adService = new AdService();
        $ads = $adService->getUserAds($marketer->id, 'approved');

        foreach ($ads->items() as $ad) {
            $ad->owner = $marketer;
        }
        return AdsResource::collection($ads);
    }
}