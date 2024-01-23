<?php

namespace Modules\Ad\Http\Controllers\Front\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Ad\DataTransferObject\AdDto;
use Modules\Ad\Http\Requests\AdStoreRequest;
use Modules\Ad\Services\AdService;
use Modules\Ad\Services\ValidationService;
use Modules\Category\Entities\Category;
use Modules\City\Entities\City;
use Modules\Estate\DataTransferObject\EstateDto;
use Modules\Media\DataTransferObject\MediaDto;
use Modules\Media\Services\MediaService;
use Modules\Subscription\Services\SubscriptionService;
use Modules\Ad\Http\Requests\Api\AdFilterRequest;
use Modules\Ad\Services\AdLicenseService;

class AdLicenseController extends Controller
{
    public function __construct(
        private MediaService $mediaService,
        private AdService $adService,
        private AdLicenseService $adLicenseService,
    ) {
    }

    public function ajax(AdFilterRequest $request)
    {
        $ads = $this->adService->getUserLicenseAdRequests(auth()->id(), $request->get('status'));

        return response()->json([
            'data' =>  view('ad::front.license-requests.container', compact('ads'))->render(),
            'has_more' => $ads->hasMorePages(),
        ]);
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        ValidationService::validateStep('license-request');
        // SubscriptionService::checkHasActiveSubscription();
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
        ValidationService::validateStep('license-request');
        // SubscriptionService::checkHasActiveSubscription();
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
        session()->forget('license_number');
        $adDto = new AdDto($request->get('type'), $request->get('price'), auth()->user());
        $adDto
            ->setAdvertiserRelation($request->get('advertiser_relation', 'owner'))
            ->setInstrumentNumber($request->get('instrument_number'))
            ->setCategoryID($request->get('category_id'))
            ->setArea($request->get('area'));
        // ->setAdTypeID($request->get('ad_type_id'));
        $ad = $this->adLicenseService->createOrUpdate($adDto, $estateDto);
        if ($ad->status->value == 'pending') {
            //pay fees
        }
        return \redirect()->route('front.index');
    }
}
