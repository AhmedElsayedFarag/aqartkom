<?php

namespace Modules\Estate\Filters;

use Closure;
use Illuminate\Http\Request;

class Map
{
    public function handle($request, Closure $next)
    {
        if (request()->has('center') && request()->has('second_point')) {

            $center = request()->get('center');
            $second = request()->get('second_point');
            $distance = getDistanceBetweenPoints($center['lat'], $center['long'], $second['lat'], $second['long']);
            $lat = $center['lat'];
            $long = $center['long'];
            return $next($request)->whereRaw("ACOS(SIN(RADIANS(lat))*SIN(RADIANS($lat))+COS(RADIANS(lat))*COS(RADIANS($lat))*COS(RADIANS(estates.long)-RADIANS($long)))*6380 < $distance");
        }
        return $next($request);
    }
}