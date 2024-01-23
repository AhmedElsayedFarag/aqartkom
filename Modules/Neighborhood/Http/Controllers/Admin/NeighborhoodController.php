<?php

namespace Modules\Neighborhood\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Routing\Controller;
use Modules\City\Entities\City;
use Modules\City\Http\Requests\CityFilterRequest;
use Modules\Neighborhood\Entities\Neighborhood;
use Modules\Neighborhood\Http\Requests\NeighborhoodRequest;
use Modules\Users\Filters\Search;

class NeighborhoodController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(CityFilterRequest $request, City $city)
    {
        $neighborhoods = app(Pipeline::class)
            ->send(Neighborhood::select(['id', 'name'])
                ->filterCity($city->id))
            ->through([
                Search::class,
            ])
            ->thenReturn()
            ->orderBy('name')
            ->paginate(15);
        return view('neighborhood::admin.index', compact('neighborhoods', 'city'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(City $city)
    {
        return view('neighborhood::admin.create', compact('city'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(NeighborhoodRequest $request, City $city)
    {
        $request->merge(['city_id' => $city->id]);
        Neighborhood::create($request->all());
        return \success_add('neighborhood.index', ['city' => $city->id]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(City $city, Neighborhood $neighborhood)
    {
        return view('neighborhood::admin.edit', compact('city', 'neighborhood'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(NeighborhoodRequest $request, City $city, Neighborhood $neighborhood)
    {
        $neighborhood->update(['name' => $request->get('name')]);

        return \success_update('neighborhood.index', ['city' => $city->id]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(City $city, Neighborhood $neighborhood)
    {
        if ($neighborhood->estates()->count()) {
            session()->flash('danger', __('messages.category_cannot_be_deleted'));
            return redirect()->back();
        }
        $neighborhood->delete();
        return \success_delete('neighborhood.index', ['city' => $city->id]);
    }
}