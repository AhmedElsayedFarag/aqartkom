<?php

namespace Modules\Package\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Package\Entities\Package;
use Modules\Package\Services\Api\PackageService;
use Modules\Package\Transformers\PackageResource;

class PackageController extends Controller
{
    public function index()
    {
        return PackageResource::collection(PackageService::getAll(auth()->user()->type));
    }
    public function getAll(Request $request)
    {
        $request->validate([
            'type' => 'required|in:owner,marketer,company',
        ]);
        return PackageResource::collection(PackageService::getAll($request->type));
    }
}