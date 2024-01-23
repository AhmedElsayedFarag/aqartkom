<?php

namespace Modules\Ad\Http\Controllers\Api;

use App\Helpers\FavoriteTrait;
use App\Helpers\JsonResponseMessages;
use App\Models\AdView;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Ad\Entities\Ad;
use Modules\Ad\Entities\CustomerContact;
use Modules\Ad\Http\Requests\AdReportRequest;
use Modules\Ad\Http\Requests\Api\AdUserFilterRequest;
use Modules\Ad\Http\Requests\Api\AdVisitRequest;
use Modules\Ad\Services\AdService;
use Modules\Ad\Transformers\AdShowResource;
use Modules\Ad\Transformers\AdsResource;
use Modules\Ad\Transformers\CustomerContactResource;
use Modules\Package\Enums\PackageFeatureTypeEnum;
use Modules\Subscription\Services\Features\IncrementFeatureUsageHandler;
use Modules\Subscription\Services\SubscriptionService;

class AdMarketingController extends Controller
{
    use FavoriteTrait;

    public function __construct(private AdService $adService)
    {
        $this->middleware('not_authorized')->only(['contact']);
    }


    /**
     * Display a listing of ads
     * @return Renderable
     */
    public function index(AdUserFilterRequest $request)
    {
        \abort_if(auth()->user()->type != 'marketer', 422, __('messages.you_are_not_marketer'));
        return AdsResource::collection($this->adService->getAllAdMarketing()->paginate(100));
    }

    public function contact(Ad $ad)
    {
        $customerContact = CustomerContact::query()->where('customer_id', $ad->user_id)->where('marketer_id', auth()->id())->first();
        if (!is_null($customerContact)) {
            return new CustomerContactResource($customerContact);
        }
        \abort_if(auth()->user()->type != 'marketer', 422, __('messages.you_are_not_marketer'));
        return DB::transaction(function () use ($ad) {
            SubscriptionService::checkHasActiveSubscription();
            $activeSubscription = SubscriptionService::getActiveSubscription();
            $feature = $activeSubscription->getFeature(PackageFeatureTypeEnum::ContactMarketingRequests);
            $handler = new IncrementFeatureUsageHandler();
            $handler->handle($feature, $ad);
            $customerContact = CustomerContact::create([
                'customer_id' => $ad->user_id,
                'marketer_id' => auth()->id(),
                'customer_name' => $ad->owner_name,
                'customer_phone' => $ad->owner_phone,
                'marketer_phone' => auth()->user()->name,
                'marketer_name' => auth()->user()->phone,
            ]);
            return new CustomerContactResource($customerContact);
        });
    }
}