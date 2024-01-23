<?php

namespace Modules\Ad\Http\Controllers\Front\User;

use App\DataTransferObjects\CoordinateDto;
use App\Helpers\JsonResponseMessages;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Ad\DataTransferObject\AdDto;
use Modules\Ad\Entities\Ad;
use Modules\Ad\Http\Requests\AdFeatureRequest;
use Modules\Ad\Http\Requests\AdStoreRequest;
use Modules\Ad\Http\Requests\AdUpdateRequest;
use Modules\Ad\Http\Requests\Api\AdFilterRequest;
use Modules\Ad\Services\AdService;
use Modules\Ad\Services\ValidationService;
use Modules\Category\Entities\Category;
use Modules\City\Entities\City;
use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Services\CouponService;
use Modules\Estate\DataTransferObject\EstateDto;
use Modules\Estate\Entities\EstateMedia;
use Modules\Media\DataTransferObject\MediaDto;
use Modules\Media\Services\MediaService;
use Modules\Package\Entities\AdFeaturePackage;
use Modules\Subscription\Services\Features\AdFeatureHandler;
use Modules\Subscription\Services\SubscriptionService;
use Modules\Transaction\DTO\PaymentAmountDTO;
use Modules\Transaction\DTO\PaymentDTO;
use Modules\Transaction\Enums\PaymentTypeEnum;
use Modules\Transaction\Services\PaymentService;

class AdsController extends Controller
{
    public function __construct(
        private MediaService $mediaService,
        private AdService $adService,
    ) {
    }
    public function ajax(AdFilterRequest $request)
    {
        $ads = $this->adService->getUserAds(auth()->id(), $request->get('status'));
        $activeSubscription = SubscriptionService::getActiveSubscription();
        $haveToPay = true;
        if (!is_null($activeSubscription)) {
            $adFeature = $activeSubscription->features->where('type', 'ad_feature');
            $haveToPay = $adFeature->remaining_count != 0;
        }

        return response()->json([
            'data' =>  view('ad::front.user.ads-container', compact('ads', 'haveToPay'))->render(),
            'has_more' => $ads->hasMorePages(),
        ]);
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('ad::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        ValidationService::validateStep('licensed-ad');
        //check on package , count of ads free and type of user
        ValidationService::validateAddingAds();
        ValidationService::hasLicenseNumber();
        $categories = Category::select(['id', 'name', 'is_building', 'is_price_per_meter'])->get();
        $cities = City::select(['id', 'name'])->get();
        return view('ad::front.create', compact('cities', 'categories'));
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(AdStoreRequest $request)
    {
        ValidationService::validateStep('licensed-ad');
        //check on package , count of ads free and type of user
        ValidationService::validateAddingAds();
        ValidationService::hasLicenseNumber();
        $media = [];
        foreach ($request->file('media') as $file) {
            $mediaDto = new MediaDto($file, 'media');
            $media[] = $this->mediaService->create($mediaDto)->uuid;
        }
        $estateDto = new EstateDto(
            $request->get('estate'),
            $request->get('details') ?? [],
            $media,
        );
        $adDto = new AdDto($request->get('type'), $request->get('price'), auth()->user());
        $adDto->setLicenseNumber(session('license_number'))
            ->setAdvertiserRelation($request->get('advertiser_relation', 'owner'))
            ->setInstrumentNumber($request->instrument_number)
            ->setCategoryID($request->estate['category'])
            ->setArea($request->area);
        // ->setAdTypeID($request->type_id);
        $ad = $this->adService->createOrUpdate($adDto, $estateDto);
        session()->forget('license_number');
        return \redirect()->route('front.aqar.show', $ad->uuid);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Ad $ad)
    {
        $ad->load([
            'estate',
            'estate.city:id',
            'estate.category',
            'estate.details' => fn ($query) => $query->select(['estate_id', 'estate_attribute_id', 'estate_attribute_value_id', 'value']),
            'estate.details.attribute' => fn ($query) => $query->select(['id', 'name', 'type', 'unit']),
            'estate.details.attributeValue' => fn ($query) => $query->select(['id', 'value']),
            'estate.details.attribute.values' => fn ($query) => $query->select(['id', 'estate_attribute_id', 'value'])
        ]);
        $categories = Category::select(['id', 'name', 'is_building'])->get();
        $cities = City::select(['id', 'name'])->get();
        $neighborhoods = $ad->estate->city->neighborhoods()->select(['id', 'name'])->get();
        return view('ad::front.edit', compact('cities', 'categories', 'ad', 'neighborhoods'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(AdUpdateRequest $request, Ad $ad)
    {
        $media = [];
        if ($request->has('media'))
            foreach ($request->file('media') as $file) {
                $mediaDto = new MediaDto($file, 'media');
                $media[] = $this->mediaService->create($mediaDto)->uuid;
            }
        $adDto = new AdDto($request->get('type'), $request->get('price'), $ad->owner);
        $estateDto = new EstateDto(
            $request->get('estate'),
            $request->get('details') ?? [],
            $media
        );
        $this->adService->createOrUpdate($adDto, $estateDto, $ad);
        return \redirect()->route('front.profile.ads');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Ad $ad)
    {
        $ad->delete();
    }
    public function destroyMedia($media)
    {
        $media = EstateMedia::where('uuid', $media)->with(['estate:id', 'estate.ad:estate_id,user_id'])->firstOrFail();
        $this->adService->isAdOwner($media->estate->ad);
        $media->delete();
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
    public function refresh(Ad $ad)
    {
        if ($ad->status->value == 'approved')
            $ad->update(['accepted_at' => now()->toDateTimeString()]);
        return JsonResponseMessages::updated();
    }
    public function showFeatureForm()
    {
        if (!request()->has('package'))
            return redirect()->back();
        $ad = Ad::where('uuid', request()->get('ad'))->firstOrFail();
        $this->adService->isAdOwner($ad);
        $package = AdFeaturePackage::findOrFail(request()->get('package'));
        return view('ad::front.feature-form', compact('ad', 'package'));
    }
    public function buyAdFeature(AdFeatureRequest $request, Ad $ad)
    {
        $link = DB::transaction(function () use ($request, $ad) {
            $this->adService->isAdOwner($ad);
            $paymentService = new PaymentService();
            $package = AdFeaturePackage::find($request->get('package'));
            if ($request->has('coupon')) {
                $coupon = Coupon::where('code', $request->coupon)->first();
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
        if (strlen($link))
            return redirect()->away($link);
        return redirect()->to(route('front.index'));
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
}