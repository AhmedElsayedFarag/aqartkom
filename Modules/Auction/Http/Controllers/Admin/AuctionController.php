<?php

namespace Modules\Auction\Http\Controllers\Admin;

use App\DataTransferObjects\CoordinateDto;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Routing\Controller;
use Modules\Auction\DataTransferObjects\AuctionDto;
use Modules\Auction\Entities\Auction;
use Modules\Auction\Http\Requests\AuctionFilterRequest;
use Modules\Auction\Http\Requests\StoreAuctionRequest;
use Modules\Auction\Http\Requests\UpdateAuctionRequest;
use Modules\Auction\Services\AuctionService;
use Modules\Category\Entities\Category;
use Modules\City\Entities\City as EntitiesCity;
use Modules\Estate\DataTransferObject\EstateDto;
use Modules\Estate\Filters\City;
use Modules\Estate\Filters\Search;
use Modules\Media\DataTransferObject\MediaDto;
use Modules\Media\Services\LocalMediaService;
use Modules\Media\Services\MediaService;
use Modules\Media\Services\RemoteMediaService;

class AuctionController extends Controller
{

    public function __construct(private MediaService $mediaService)
    {
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(AuctionFilterRequest $request)
    {

        $auctions = AuctionService::getAdminAll();
        return view('auction::admin.auctions.index', compact('auctions'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $coordinate = new CoordinateDto(latName: "estate[lat]", longName: "estate[long]");
        $categories = Category::select(['id', 'name', 'is_building'])->get();
        $cities = EntitiesCity::select(['id', 'name'])->get();
        return view('auction::admin.auctions.create', compact('cities', 'categories', 'coordinate'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StoreAuctionRequest $request)
    {
        $media = [];
        foreach ($request->file('media') as $file) {
            $mediaDto = new MediaDto($file, 'media');
            $media[] = $this->mediaService->create($mediaDto)->uuid;
        }
        $estateDto = new EstateDto(
            [...$request->get('estate'), 'type' => 'auction'],
            $request->get('details') ?? [],
            $media,
        );
        $auctionDto = new AuctionDto($request->get('end_at'), $request->get('initial_price'));
        $auctionService = new AuctionService();
        $auctionService->createOrUpdate($auctionDto, $estateDto);

        return \success_add('auction.index');
    }
    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Auction $auction)
    {
        $auction->load([
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
            lat: $auction->estate->lat,
            long: $auction->estate->long,
        );
        $categories = Category::select(['id', 'name', 'is_building'])->get();
        $cities = EntitiesCity::select(['id', 'name'])->get();
        $model = $auction;
        return view('auction::admin.auctions.edit', compact('cities', 'categories', 'model', 'coordinate'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateAuctionRequest $request, Auction $auction)
    {

        $auctionDto = new AuctionDto($auction->end_at, $auction->initial_price);
        $estateDto = new EstateDto(
            [...$request->get('estate'), 'type' => 'auction'],
            $request->get('details') ?? [],
            $request->get('media') ?? []
        );
        $auctionService = new AuctionService();
        $auctionService->createOrUpdate($auctionDto, $estateDto, $auction);
        return success_update('auction.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Auction $auction)
    {

        $auction->delete();
        return \success_delete('auction.index');
    }
    public function terminate(Auction $auction)
    {
        AuctionService::terminate($auction);
        return \success_update('auction.index');
    }
}