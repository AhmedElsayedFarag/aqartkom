<?php

namespace Modules\Estate\Filters;

use Closure;
use Illuminate\Http\Request;

class City
{
    public function handle($request, Closure $next)
    {
        if (request()->has('city') && request()->get('city') != null) {
            return $next($request)->where('city_id', request()->get('city'));
        }
        return $next($request);
    }
}