<?php

namespace Modules\Ad\Http\Controllers\Front;

use App\Helpers\FavoriteTrait;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Ad\Entities\Ad;
use Modules\Ad\Entities\AdFilter;
use Modules\Ad\Http\Requests\Front\AdFilterRequest;
use Modules\Ad\Services\AdService;
use Modules\Category\Services\CategoriesService;
use Modules\City\Services\CitiesService;
use Modules\Favorite\Services\FavoriteAdService;
use Modules\Favorite\Services\FavoriteService;

class AdsController extends Controller
{

    use FavoriteTrait;
    public function __construct(private AdService $adService)
    {
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(AdFilterRequest $request)
    {

        $categories = CategoriesService::getAll();
        $filters = AdFilter::select(['name', 'group', 'values'])->get()->groupBy('group')->toArray();
        $cities = CitiesService::getAll();
        return view('ad::front.index', \compact('categories', 'filters', 'cities'));
    }
    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Ad $ad)
    {
        $ad->views++;
        $ad->save();
        $this->adService->loadRelations($ad);
        $ad->is_favorite = $this->addIsFavorite($ad->id, Ad::class);
        request([
            'city' => $ad->estate->city_id,
            'neighborhood' => $ad->estate->neighborhood_id,
        ]);
        $nearbyAds = $this->adService->getAll()->limit(6)->get();
        $isFavorite = auth()->check() ? (new FavoriteService(new FavoriteAdService))->isExist($ad->id) : false;
        return view('ad::front.show', \compact('ad', 'nearbyAds', 'isFavorite'));
    }
}
