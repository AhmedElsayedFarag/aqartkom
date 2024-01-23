<?php

namespace Modules\Estate\Filters;

use Closure;
use Illuminate\Http\Request;

class Area
{
    public function handle($request, Closure $next)
    {
        if (request()->has('area') && request()->get('area')[0] != null && request()->get('area')[1] != null) {
            return $next($request)->whereBetween('area', request()->get('area'));
        }
        return $next($request);
    }
}