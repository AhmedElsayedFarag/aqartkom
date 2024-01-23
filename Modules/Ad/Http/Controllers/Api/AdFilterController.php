<?php

namespace Modules\Ad\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Ad\Entities\AdFilter;
use Modules\Ad\Transformers\AdFilterResource;

class AdFilterController extends Controller
{
    public function __invoke()
    {
        return AdFilterResource::collection(AdFilter::select(['name', 'group', 'values'])->get());
    }
}