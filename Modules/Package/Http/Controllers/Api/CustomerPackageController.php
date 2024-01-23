<?php

namespace Modules\Package\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Package\Transformers\PackageResource;

class CustomerPackageController extends Controller
{
    public function __invoke()
    {
        return PackageResource::collection(\Modules\Package\Services\Api\PackageService::getAll(auth()->user()->type));
    }
}