<?php

namespace Modules\Package\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Package\Entities\Package;
use Modules\Package\Http\Requests\Admin\PackageRequest;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $packages = Package::paginate();
        return view('package::admin.index', \compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('package::admin.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(PackageRequest $request)
    {
        Package::create($request->validated());
        return \success_add('package.index');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Package $package)
    {
        return view('package::admin.edit', \compact('package'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(PackageRequest $request, Package $package)
    {
        $package->update($request->validated());
        return \success_update('package.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Package $package)
    {
        $package->delete();
        return \success_delete('package.index');
    }
}