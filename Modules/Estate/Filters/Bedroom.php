<?php

namespace Modules\Estate\Filters;

use Closure;
use Illuminate\Http\Request;

class Bedroom
{
    public function handle($request, Closure $next)
    {
        if (request()->has('bedroom') && request()->get('bedroom')[0] != null) {
            return $next($request)->whereIn('bedroom', request()->get('bedroom'));
        }
        return $next($request);
    }
}