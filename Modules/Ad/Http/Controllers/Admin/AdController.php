<?php

namespace Modules\Ad\Http\Controllers\Admin;

use App\DataTransferObjects\CoordinateDto;
use App\Services\TakamolatService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Ad\DataTransferObject\AdDto;
use Modules\Ad\Entities\Ad;
use Modules\Ad\Http\Requests\AdFilterRequest;
use Modules\Ad\Http\Requests\AdStoreRequest;
use Modules\Ad\Http\Requests\AdUpdateRequest;
use Modules\Ad\Http\Requests\AdVerifyRequest;
use Modules\Ad\Services\AdService;
use Modules\Category\Entities\Category;
use Modules\City\Entities\City;
use Modules\Estate\DataTransferObject\EstateDto;
use Modules\Estate\Services\EstateService;
use Modules\Media\DataTransferObject\MediaDto;
use Modules\Media\Services\MediaService;
use Modules\Transaction\Entities\Transaction;
use Modules\Transaction\Enums\PaymentTypeEnum;

class AdController extends Controller
{
    /**
     * filter by status
     * filter by search
     * filter by city
     * page for pending ads
     */
    public function __construct(
        private MediaService $mediaService,
        private AdService $adService,
    ) {
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(AdFilterRequest $request)
    {
        $categories = Category::select(['id', 'name'])->get();
        $cities = City::select(['id', 'name'])->get();
        $ads = $this->adService->getAdminAll()->paginate(15)->withQueryString();
        return view('ad::ads.index', compact('ads', 'categories', 'cities'));
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function unlicensed(AdFilterRequest $request)
    {
        $categories = Category::select(['id', 'name'])->get();
        $cities = City::select(['id', 'name'])->get();
        $ads = $this->adService->getUnlicensedAdminAll()->paginate(15)->withQueryString();
        return view('ad::ads.index', compact('ads', 'categories', 'cities'));
    }

    public function show(Ad $ad)
    {
        $this->adService->loadRelations($ad);
        $ad->details = EstateService::formatDetails($ad->estate);

        $coordinate = new CoordinateDto(
            latName: "estate[lat]",
            longName: "estate[long]",
            lat: $ad->estate->lat,
            long: $ad->estate->long,
        );

        return view('ad::ads.show', compact('ad', 'coordinate'));
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function requests(AdFilterRequest $request)
    {
        $categories = Category::select(['id', 'name'])->get();
        $cities = City::select(['id', 'name'])->get();
        $ads = $this->adService->getAdminAll()->status('pending')->paginate(15)->withQueryString();
        return view('ad::ads-request', compact('ads', 'categories', 'cities'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $coordinate = new CoordinateDto(latName: "estate[lat]", longName: "estate[long]");
        $categories = Category::select(['id', 'name', 'is_building'])->get();
        $cities = City::select(['id', 'name'])->get();
        return view('ad::ads.create', compact('cities', 'categories', 'coordinate'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(AdStoreRequest $request)
    {
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
        /**
         * request()->get('instrument_number')
         * request()->get('advertiser_relation', 'owner')
         * request()->get('license_number')
         */
        $adDto->setAdvertiserRelation($request->get('advertiser_relation', 'owner'))
            ->setInstrumentNumber($request->instrument_number)
            ->setCategoryID($request->estate['category'])
            ->setArea($request->area);

        $ad = $this->adService->createOrUpdate($adDto, $estateDto);
        $this->adService->accept($ad);
        return \success_add('ad.index');
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
            'estate.category',
            'estate.details' => fn ($query) => $query->select(['estate_id', 'estate_attribute_id', 'estate_attribute_value_id', 'value']),
            'estate.details.attribute' => fn ($query) => $query->select(['id', 'name', 'type', 'unit']),
            'estate.details.attributeValue' => fn ($query) => $query->select(['id', 'value']),
            'estate.details.attribute.values' => fn ($query) => $query->select(['id', 'estate_attribute_id', 'value'])
        ]);
        $coordinate = new CoordinateDto(
            latName: "estate[lat]",
            longName: "estate[long]",
            lat: $ad->estate->lat,
            long: $ad->estate->long,
        );
        $categories = Category::select(['id', 'name', 'is_building'])->get();
        $cities = City::select(['id', 'name'])->get();
        $model = $ad;
        return view('ad::ads.edit', compact('cities', 'categories', 'model', 'coordinate'));
    }



    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(AdUpdateRequest $request, Ad $ad)
    {

        $adDto = new AdDto($request->get('type'), $request->get('price'), $ad->owner);
        $adDto->setAdvertiserRelation($request->get('advertiser_relation', 'owner'))
            ->setInstrumentNumber($request->instrument_number)
            ->setCategoryID($request->estate['category'])
            ->setArea($request->area);
        $estateDto = new EstateDto(
            $request->get('estate'),
            $request->get('details') ?? [],
            $request->get('media') ?? []
        );
        $this->adService->createOrUpdate($adDto, $estateDto, $ad);
        // $this->adService->accept($ad);
        return success_update('ad.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Ad $ad)
    {

        $ad->delete();
        return \success_delete('ad.index');
    }

    public function accept(Ad $ad)
    {
        $this->adService->accept($ad);
        return success_update('ad.index');
    }

    public function cancel(Ad $ad)
    {
        $this->adService->cancel($ad);
        return success_update('ad.index');
    }
    public function showInvoice(Ad $ad)
    {
        $invoice = Transaction::where('transactionable_id', $ad->id)
            ->where('service_type', PaymentTypeEnum::AdvertisingLicense)
            ->firstOrFail();
        return view('ad::ads.license_invoice', compact('ad', 'invoice'));
    }
}