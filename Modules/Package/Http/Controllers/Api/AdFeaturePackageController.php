<?php

namespace Modules\Package\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Package\Transformers\AdFeaturePackageResource;

class AdFeaturePackageController extends Controller
{
    public function __invoke()
    {
        return AdFeaturePackageResource::collection(\Modules\Package\Entities\AdFeaturePackage::type(auth()->user()->type)->get());
    }
}