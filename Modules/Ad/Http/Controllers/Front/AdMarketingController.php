<?php

namespace Modules\Ad\Http\Controllers;

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

class AdMarketingController extends Controller
{
    public function index(AdFilterRequest $request)
    {
        if (auth('sanctum')->user()->type != 'marketer') {
            return redirect()->route('front.aqar.index');
        }
        $adService = new AdService;
        $categories = CategoriesService::getAll();
        $filters = AdFilter::select(['name', 'group', 'values'])->get()->groupBy('group')->toArray();
        $cities = CitiesService::getAll();
        return view('ad::front.marketing-requests', \compact('categories', 'filters', 'cities'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('ad::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('ad::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('ad::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}