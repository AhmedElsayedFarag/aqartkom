<?php

namespace Modules\Package\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Package\Entities\Package;
use Modules\Package\Enums\PackageFeatureTypeEnum;
use Modules\Package\Http\Requests\CompanyPackageRequest;
use Modules\Package\Services\Admin\CompanyPackageService;

class CompanyPackageController extends Controller
{
    public function __construct(private CompanyPackageService $service)
    {
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $packages = $this->service->getAll();
        return view('package::admin.company.index', \compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $attributes = $this->service->getAttributes();
        return view('package::admin.company.create', \compact('attributes'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CompanyPackageRequest $request)
    {
        $this->service->create($request->validated());
        return success_add('company-package.index');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Package $package)
    {
        $attributes = $this->service->getAttributes();
        $features = $package->features->map(function ($feature) {
            return [
                'id' => $feature->id,
                'title' => $feature->title,
                'type' => $feature->type->value,
                'value' => $feature->value,
            ];
        })->keyBy('type')->toArray();
        return view('package::admin.company.edit', compact('package', 'attributes', 'features'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(CompanyPackageRequest $request, Package $package)
    {
        $this->service->update($package, $request->validated());
        return success_update('company-package.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Package $package)
    {
        $package->delete();
        return success_delete('company-package.index');
    }
}