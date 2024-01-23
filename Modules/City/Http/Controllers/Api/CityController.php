<?php

namespace Modules\City\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\City\Http\Resources\CityResource;
use Modules\City\Services\CitiesService;

class CityController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return CityResource::collection(CitiesService::getAll());
    }
}
