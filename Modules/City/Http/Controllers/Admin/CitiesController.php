<?php

namespace Modules\City\Http\Controllers\Admin;

use App\DataTransferObjects\CoordinateDto;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Pipeline\Pipeline;
use Modules\City\Entities\City;
use Modules\City\Http\Requests\CityFilterRequest;
use Modules\City\Http\Requests\CityRequest;
use Modules\Users\Filters\Search;

class CitiesController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(CityFilterRequest $request)
    {
        $cities = app(Pipeline::class)
            ->send(City::select(['id', 'name']))
            ->through([
                Search::class,
            ])
            ->thenReturn()
            ->orderBy('name')
            ->paginate(15);
        return view('city::admin.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $coordinate = new CoordinateDto();
        return view('city::admin.create', compact('coordinate'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CityRequest $request)
    {
        City::create($request->all());
        return \success_add('city.index');
    }
    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(City $city)
    {
        $coordinate = new CoordinateDto(
            lat: $city->lat,
            long: $city->long,
        );
        return view('city::admin.edit', compact('city', 'coordinate'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(CityRequest $request, City $city)
    {
        $city->update($request->all());
        if ($city) {
            return \success_update('city.index');
        }
        abort(500);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(City $city)
    {
        if ($city->estates()->count()) {
            session()->flash('danger', __('messages.cannot_be_deleted'));
            return redirect()->back();
        }
        $city->delete();
        return \success_delete('city.index');
    }
}