<?php

namespace Modules\Neighborhood\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\City\Entities\City;
use Modules\Neighborhood\Services\NeighborhoodsService;
use Modules\Neighborhood\Http\Resources\NeighborhoodResource;

class NeighborhoodController extends Controller
{
    public function __invoke(City $city)
    {
        return NeighborhoodResource::collection(NeighborhoodsService::getAll($city->id));
    }
}