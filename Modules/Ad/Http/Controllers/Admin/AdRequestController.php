<?php

namespace Modules\Ad\Http\Controllers\Admin;

use App\DataTransferObjects\CoordinateDto;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Ad\DataTransferObject\AdRequestDto;
use Modules\Ad\Entities\AdRequest;
use Modules\Ad\Entities\AdVisit;
use Modules\Ad\Http\Requests\AdFilterRequest;
use Modules\Ad\Http\Requests\Api\AdRequestRequest;
use Modules\Ad\Services\AdRequestService;
use Modules\Category\Entities\Category;
use Modules\City\Entities\City;
use Modules\Estate\DataTransferObject\EstateDto;
use Modules\Estate\Services\EstateService;

class AdRequestController extends Controller
{
    // /**
    //  * Display a listing of the resource.
    //  * @return Renderable
    //  */
    // public function index()
    // {
    //     $visits = AdRequest::with(['city:id,name', 'category:id,name'])->latest()->paginate(15);
    //     return view('ad::requests', compact('visits'));
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  * @param int $id
    //  * @return Renderable
    //  */
    // public function destroy(AdRequest $request)
    // {
    //     $request->delete();
    //     return \success_delete('ad-request.index');
    // }

    /**
     * filter by status
     * filter by search
     * filter by city
     * page for pending ads
     */
    public function __construct(
        private AdRequestService $requestService,
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
        $ads = $this->requestService->getAdminAll()->paginate(15)->withQueryString();

        return view('ad::requests.index', compact('ads', 'categories', 'cities'));
    }

    public function show(AdRequest $request)
    {
        $this->requestService->loadRelations($request);
        $request->details = EstateService::formatDetails($request->estate);
        return view('ad::requests.show', compact('request'));
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
        return view('ad::requests.create', compact('cities', 'categories', 'coordinate'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(AdRequestRequest $request)
    {
        $media = [];
        // foreach ($request->file('media') as $file) {
        //     $mediaDto = new MediaDto($file, 'media');
        //     $media[] = $this->mediaService->create($mediaDto)->uuid;
        // }
        $estateDto = new EstateDto(
            $request->get('estate'),
            $request->get('details') ?? [],
            $media,
        );
        $requestDto = new AdRequestDto($request->get('type'), $request->get('price'), auth()->user());
        $request = $this->requestService->createOrUpdate($requestDto, $estateDto);
        $this->requestService->accept($request);
        return \success_add('ad-request.index');
    }
    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(AdRequest $request)
    {
        $request->load([
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
            lat: $request->estate->lat,
            long: $request->estate->long,
        );
        $categories = Category::select(['id', 'name', 'is_building'])->get();
        $cities = City::select(['id', 'name'])->get();
        $model = $request;
        return view('ad::requests.edit', compact('cities', 'categories', 'model', 'coordinate'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(AdRequestRequest $updateRequest, AdRequest $request)
    {

        $requestDto = new AdRequestDto($updateRequest->get('type'), $updateRequest->get('price'), $request->owner);
        $estateDto = new EstateDto(
            $updateRequest->get('estate'),
            $updateRequest->get('details') ?? [],
            $updateRequest->get('media') ?? []
        );
        $adRequest = $request;
        $this->requestService->createOrUpdate($requestDto, $estateDto, $request);
        // $this->requestService->accept($request);
        return success_update('ad-request.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(AdRequest $request)
    {

        $request->delete();
        return \success_delete('ad-request.index');
    }

    public function accept(AdRequest $request)
    {
        $this->requestService->accept($request);
        return success_update('ad-request.index');
    }

    public function cancel(AdRequest $request)
    {
        $this->requestService->cancel($request);
        return success_update('ad-request.index');
    }
}
