<?php

namespace Modules\Ad\Http\Controllers\Api;

use App\Exceptions\AdMediaMustBeAddedException;
use App\Exceptions\AdRefreshIsImmutableException;
use App\Helpers\JsonResponseMessages;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Ad\DataTransferObject\AdDto;
use Modules\Ad\Entities\Ad;
use Modules\Ad\Enums\AdStatusEnum;
use Modules\Ad\Http\Requests\AdFeatureRequest;
use Modules\Ad\Http\Requests\Api\AdFilterRequest;
use Modules\Ad\Http\Requests\Api\AdLicenseRequest;
use Modules\Ad\Http\Requests\Api\AdRequest;
use Modules\Ad\Http\Requests\Api\AdUpdateRequest;
use Modules\Ad\Services\AdLicenseService;
use Modules\Ad\Services\AdService;
use Modules\Ad\Transformers\AdShowResource;
use Modules\Ad\Transformers\User\AdLicenseShowResource;
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

class AdLicenseController extends Controller
{
    public function __construct(private AdService $adService, private AdLicenseService $licenseService)
    {
        $this->middleware('not_authorized')->only(['store']);
    }
    /**
     * Display a listing of the resource  where not licensed request
     * @return Response
     */
    public function index(AdLicenseRequest $request)
    {

        return
            AdsResource::collection(
                $this->adService
                    ->getUserLicenseAdRequests(auth()->id(), $request->get('status'), 1)
            );
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(AdRequest $request)
    {

        // \abort_if(auth()->user()->type == 'customer', 422, __('messages.user_is_not_allowed_to_add_ad'));
        $adDto = new AdDto(
            $request->get('type'),
            $request->get('price'),
            auth()->user(),
        );
        $estateDto = new EstateDto(
            [...$request->get('estate'), 'type' => 'ad'],
            $request->get('details') ?? [],
            $request->get('media'),
        );
        $adDto
            ->setAdvertiserRelation($request->get('advertiser_relation', 'owner'))
            ->setInstrumentNumber($request->instrument_number)
            ->setCategoryID($request->estate['category'])
            ->setArea($request->area)
            ->setBuildingNumber($request->building_number)
            ->setAdditionalNumber($request->additional_number)
            ->setPostalNumber($request->postal_number)
            // ->setAdTypeID($request->type_id)
            ->setNationalityNumber($request->nationality_number);

        $ad = $this->licenseService->createOrUpdate($adDto, $estateDto);
        return response()->json([
            'id' => $ad->uuid,
            'require_payment' => $ad->status->value == 'pending',
        ]);
    }

    public function payFees(Ad $ad)
    {
        return $this->adService->payFees($ad);
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
        return new AdLicenseShowResource($ad);
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
        $estateDto = new EstateDto(
            [...$request->get('estate'), 'type' => 'ad'],
            $request->get('details') ?? [],
            $request->get('media') ?? []
        );
        $ad = $this->licenseService->createOrUpdate($adDto, $estateDto, $ad);
        return new AdShowResource($ad);
    }

    public function cancel(Ad $ad)
    {
        $this->adService->isAdOwner($ad);
        $ad->visits()->delete();
        $ad->reports()->delete();
        $ad->delete();
        return JsonResponseMessages::deleted();
    }
}
