<?php

namespace Modules\Ad\Http\Controllers\Api;

use App\Exceptions\AdMediaMustBeAddedException;
use App\Exceptions\AdRefreshIsImmutableException;
use App\Helpers\JsonResponseMessages;
use App\Services\TakamolatService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Ad\DataTransferObject\AdDto;
use Modules\Ad\Entities\Ad;
use Modules\Ad\Enums\AdStatusEnum;
use Modules\Ad\Http\Requests\AdFeatureRequest;
use Modules\Ad\Http\Requests\Api\AdFilterRequest;
use Modules\Ad\Http\Requests\Api\AdRequest;
use Modules\Ad\Http\Requests\Api\AdUpdateRequest;
use Modules\Ad\Services\AdService;
use Modules\Ad\Transformers\AdShowResource;
use Modules\Ad\Transformers\User\AdShowResource as UserAdShowResource;
use Modules\Ad\Transformers\User\AdsResource;
use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Services\CouponService;
use Modules\Estate\DataTransferObject\EstateDto;
use Modules\Estate\Entities\EstateMedia;
use Modules\Package\Entities\AdFeaturePackage;
use Modules\Setting\Services\SettingsService;
use Modules\Subscription\Services\Features\AdFeatureHandler;
use Modules\Subscription\Services\SubscriptionService;
use Modules\Transaction\DTO\PaymentAmountDTO;
use Modules\Transaction\DTO\PaymentDTO;
use Modules\Transaction\Enums\PaymentTypeEnum;
use Modules\Transaction\Services\PaymentService;
use Nette\Utils\Json;

class AdUserController extends Controller
{
    public function __construct(private AdService $adService)
    {
        $this->middleware('not_authorized')->only(['store']);
    }
    /**
     * Display a listing of the resource  where not licensed request
     * @return Response
     */
    public function index(AdFilterRequest $request)
    {

        return AdsResource::collection(
            $this->adService
                ->getUserAds(auth()->id(), $request->get('status'), 0)
        );
    }

    /**
     * Display a listing of the resource where is licensed request
     * @return Response
     */
    public function AdLicenseRequest(AdFilterRequest $request)
    {

        return AdsResource::collection(
            $this->adService
                ->getUserAds(auth()->id(), $request->get('status'), 1)
        );
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(AdRequest $request)
    {
        $result = TakamolatService::createRequest(
            $request->license_number,
            $request->nationality_number,
            $request->nationality_type == 'marketer' ? 1 : 2
        );
        if (!$result['success']) {
            return \response()->json([
                'message' => $result['message']
            ]);
        }
        // \abort_if(auth()->user()->type == 'customer', 422, __('messages.user_is_not_allowed_to_add_ad'));
        $adDto = new AdDto(
            $request->get('type'),
            $request->get('price'),
            auth()->user(),
        );
        $adDto->setLicenseNumber($request->license_number)
            ->setAdvertiserRelation($request->get('advertiser_relation', 'owner'))
            ->setInstrumentNumber($request->instrument_number)
            ->setCategoryID($request->estate['category'])
            ->setArea($request->area)
            // ->setAdTypeID($request->type_id)
            ->setNationalityNumber($request->nationality_number);
        $estateDto = new EstateDto(
            [...$request->get('estate'), 'type' => 'ad'],
            $request->get('details') ?? [],
            $request->get('media'),
        );
        $ad = $this->adService->createOrUpdate($adDto, $estateDto);
        return new AdShowResource($ad);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Ad $ad)
    {
        $this->adService->isAdOwner($ad);
        $ad->load([
            ...$this->adService->getRelations(),
            'estate.details.attribute.values' => fn ($query) => $query->select(['id', 'estate_attribute_id', 'value'])
        ]);
        return new UserAdShowResource($ad);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function showAdLicenseRequest(Ad $ad)
    {
        $this->adService->isAdOwner($ad);
        $ad->load([
            ...$this->adService->getRelations(),
            'estate.details.attribute.values' => fn ($query) => $query->select(['id', 'estate_attribute_id', 'value'])
        ]);
        return new UserAdShowResource($ad);
    }

    public function addFeature(Ad $ad)
    {
        return  DB::transaction(function () use ($ad) {
            $this->adService->isAdOwner($ad);
            SubscriptionService::checkHasActiveSubscription();
            // $this->adService->isFeatured($ad);
            $activeSubscription = SubscriptionService::getActiveSubscription();
            if (is_null($activeSubscription)) {

                // $paymentService = new PaymentService();
                // $amountDto = new PaymentAmountDTO($request->get('price'), $request->get('coupon'));
                return response()->json([
                    'is_featured' => false,
                    'message' => __('messages.package_is_required_or_ad_feature_paying'),
                ]);
            } else {
                //feature ad from package feature through subscription
                $adFeatureService = new AdFeatureHandler();
                $adFeatureService->handle($activeSubscription->features->first(), $ad);
                return JsonResponseMessages::featuredSuccessfully();
            }
        });
    }
    public function buyAdFeature(AdFeatureRequest $request, Ad $ad)
    {
        return  DB::transaction(function () use ($request, $ad) {
            $this->adService->isAdOwner($ad);
            $paymentService = new PaymentService();
            $package = AdFeaturePackage::find($request->get('package'));
            if ($request->has('coupon')) {
                $coupon = Coupon::where('code', $request->coupon)->where('usage', 'services')->first();
                CouponService::validate($coupon);
            }
            $amountDto = new PaymentAmountDTO($package->price, $request->get('coupon'));
            $paymentDto = new PaymentDTO(
                auth()->user()->name,
                auth()->user()->phone,
                auth()->user()->email,
                PaymentTypeEnum::AdFeature,
                $request->payment_method,
                $ad,
                $amountDto,
                $package
            );
            return $paymentService->createLink($paymentDto);
        });
    }
    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(AdUpdateRequest $request, Ad $ad)
    {
        \abort_if($ad->user_id != auth()->id(), 404);
        // estate media =>10 | deleted_media = 10 | new media =2
        $estateMediaCount = EstateMedia::where('estate_id', $ad->estate_id)->count();
        $newMediaCount = count($request->get('media') ?? []);
        if ($estateMediaCount + $newMediaCount < 2) {
            throw new AdMediaMustBeAddedException();
        }
        $adDto = new AdDto(
            $request->get('type'),
            $request->get('price'),
            auth()->user(),
        );
        $adDto->setLicenseNumber($ad->license_number)
            ->setAdvertiserRelation($request->get('advertiser_relation', 'owner'))
            ->setInstrumentNumber($request->instrument_number)
            ->setCategoryID($request->estate['category'])
            ->setArea($request->area);
        // ->setAdTypeID($request->type_id);
        $estateDto = new EstateDto(
            [...$request->get('estate'), 'type' => 'ad'],
            $request->get('details') ?? [],
            $request->get('media') ?? []
        );
        $ad = $this->adService->createOrUpdate($adDto, $estateDto, $ad);
        return new AdShowResource($ad);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Ad $ad)
    {
        $this->adService->isAdOwner($ad);
        $ad->visits()->delete();
        $ad->reports()->delete();
        $ad->delete();
        return JsonResponseMessages::deleted();
    }
    public function active(Ad $ad)
    {
        $this->adService->isAdOwner($ad);
        $this->adService->active($ad);
        return JsonResponseMessages::updated();
    }
    public function unactive(Ad $ad)
    {
        $this->adService->isAdOwner($ad);
        $this->adService->unactive($ad);
        return JsonResponseMessages::updated();
    }
    public function deleteMedia(Ad $ad, EstateMedia $media)
    {
        \abort_if($ad->user_id != auth()->id(), 404);
        \abort_if($media->estate_id != $ad->estate_id, 404);
        if (EstateMedia::where('estate_id', $media->estate_id)->count() - 1 < 2) {
            throw new AdMediaMustBeAddedException();
        }
        $media->delete();
        return JsonResponseMessages::deleted();
    }
    public function refresh(Ad $ad)
    {

        if (now()->subDays(7)->isAfter($ad->accepted_at)) {

            if ($ad->status->value == 'approved')
                $ad->update(['accepted_at' => now()->toDateTimeString()]);
            return JsonResponseMessages::updated();
        } else {
            throw new AdRefreshIsImmutableException();
        }
    }

    public function cancelAdLicenceRequest(Ad $ad)
    {
        $this->adService->isAdOwner($ad);
        $ad->visits()->delete();
        $ad->reports()->delete();
        $ad->delete();
        return JsonResponseMessages::deleted();
    }
}