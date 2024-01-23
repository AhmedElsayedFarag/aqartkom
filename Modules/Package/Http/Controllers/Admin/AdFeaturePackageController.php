<?php

namespace Modules\Package\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Package\Entities\AdFeaturePackage;
use Modules\Package\Http\Requests\AdFeaturePackageRequest;

class AdFeaturePackageController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $packages = AdFeaturePackage::paginate();
        return view('package::admin.ad-feature.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('package::admin.ad-feature.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(AdFeaturePackageRequest $request)
    {

        AdFeaturePackage::create($request->all());
        return \success_add('ad-feature-package.index');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(AdFeaturePackage $package)
    {
        return view('package::admin.ad-feature.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(AdFeaturePackageRequest $request, AdFeaturePackage $package)
    {
        $package->update($request->all());
        return \success_delete('ad-feature-package.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(AdFeaturePackage $package)
    {
        $package->delete();
        return \success_delete('ad-feature-package.index');
    }
}