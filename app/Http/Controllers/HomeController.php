<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomeRequest;
use App\Services\GetCityService;
use Illuminate\Http\Request;
use Modules\Banner\Entities\Banner;
use Modules\Category\Http\Resources\FeaturedCategoryResource;
use Modules\Category\Services\FeaturedCategoriesService;
use Modules\City\Entities\City;
use Modules\City\Transformers\CityShowResource;
use Modules\Banner\Http\Resources\BannerResource;
use Modules\Neighborhood\Entities\Neighborhood;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(HomeRequest $request)
    {
        $city = GetCityService::handle($request->get('lat'), $request->get('lng'), $request->get('city'));

        return response()->json([
            'neighborhoods' => Neighborhood::select(['id', 'name'])
                ->filterCity($city->id)
                ->get(),
            'featured_categories' => FeaturedCategoryResource::collection(FeaturedCategoriesService::getAll($city->id)),
            'city' => new CityShowResource($city),
            'banners' => BannerResource::collection(Banner::with(['ad:id,uuid'])->get())
        ]);
    }
}
