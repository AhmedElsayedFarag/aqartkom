<?php

namespace Modules\Ad\Http\Controllers\Admin;

use App\DataTransferObjects\CoordinateDto;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Ad\DataTransferObject\AdDto;
use Modules\Ad\Entities\Ad;
use Modules\Ad\Http\Requests\AdFilterRequest;
use Modules\Ad\Http\Requests\AdStoreRequest;
use Modules\Ad\Http\Requests\AdUpdateRequest;
use Modules\Ad\Services\AdService;
use Modules\Category\Entities\Category;
use Modules\City\Entities\City;
use Modules\Estate\DataTransferObject\EstateDto;
use Modules\Estate\Services\EstateService;
use Modules\Media\DataTransferObject\MediaDto;
use Modules\Media\Services\MediaService;

class AdMarketingController extends Controller
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
        $ads = $this->adService->getAdminAllMarketing()->paginate(15)->withQueryString();
        return view('ad::ads.index', compact('ads', 'categories', 'cities'));
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
        return view('ad::ads.create-market', compact('cities', 'categories', 'coordinate'));
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
        $ad = $this->adService->createOrUpdateAdMarket($adDto, $estateDto);
        $this->adService->accept($ad);
        return \success_add('market.index');
    }
}
