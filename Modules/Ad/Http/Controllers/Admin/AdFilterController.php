<?php

namespace Modules\Ad\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Ad\Entities\AdFilter;
use Modules\Ad\Http\Requests\AdFiltersRequest;
use Modules\Ad\Http\Requests\UpdateAgeFilterRequest;

class AdFilterController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $filters = AdFilter::select(['group'])->groupBy('group')->get();
        return view('ad::filters.index', compact('filters'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param string $group
     * @return Renderable
     */
    public function edit(string $filter)
    {
        $filters  = AdFilter::where('group', $filter)->get();
        if (count($filters) == 0)
            abort(404);
        return view('ad::filters.edit', compact('filters', 'filter'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(AdFiltersRequest $request, string $filter)
    {
        $filters  = AdFilter::where('group', $filter)->get();
        if (count($filters) == 0)
            abort(404);
        $values = $request->get('values');
        if (count($filters) == 2) {
            if (count($values[0]) != count($values[1])) {
                session()->flash('danger', __('admin.values_count_is_not_equal'));
                return redirect()->back();
            }
            for ($i = 0; $i < count($values[0]); $i++) {
                if ($values[0][$i] > $values[1][$i]) {
                    session()->flash('danger', __('admin.min_values_should_be_min'));
                    return redirect()->back();
                }
            }
        }


        $formattedData = [];
        foreach ($filters as $key => $filter) {
            $formattedData[] = [
                'id' => $filter->id,
                'name' => $filter->name,
                'group' => $filter->group,
                'values' => \json_encode($values[$key])
            ];
        }
        AdFilter::upsert($formattedData, ['id'], ['values']);
        return \success_add('ad-filter.index');
    }
    public function updateAge(UpdateAgeFilterRequest $request)
    {
        $filter  = AdFilter::where('group', 'age')->first();
        $filter->update([
            'values' => $request->validated()['values'],
        ]);
        return \success_add('ad-filter.index');
    }
    public function editAge()
    {
        $filter  = AdFilter::where('group', 'age')->first();
        return view('ad::filters.edit-age-filter', compact('filter'));
    }
}