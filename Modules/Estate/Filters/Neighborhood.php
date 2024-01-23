<?php

namespace Modules\Estate\Filters;

use Closure;
use Illuminate\Http\Request;

class Neighborhood
{
    public function handle($request, Closure $next)
    {
        if (request()->has('neighborhood') && request()->get('neighborhood') != null) {
            return $next($request)->where('neighborhood_id', request()->get('neighborhood'));
        }
        return $next($request);
    }
}