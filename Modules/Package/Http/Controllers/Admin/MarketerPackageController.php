<?php

namespace Modules\Package\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Package\Entities\Package;
use Modules\Package\Enums\PackageFeatureTypeEnum;
use Modules\Package\Http\Requests\MarketerPackageRequest;
use Modules\Package\Services\Admin\MarketerPackageService;

class MarketerPackageController extends Controller
{
    public function __construct(private MarketerPackageService $service)
    {
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $packages = $this->service->getAll();
        return view('package::admin.marketer.index', \compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $attributes = $this->service->getAttributes();
        return view('package::admin.marketer.create', \compact('attributes'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(MarketerPackageRequest $request)
    {
        $this->service->create($request->validated());
        return success_add('marketer-package.index');
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
        return view('package::admin.marketer.edit', compact('package', 'attributes', 'features'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(MarketerPackageRequest $request, Package $package)
    {
        $this->service->update($package, $request->validated());
        return success_update('marketer-package.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Package $package)
    {
        $package->delete();
        return success_delete('marketer-package.index');
    }
}