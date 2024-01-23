<?php

namespace Modules\Estate\Filters;

use Closure;
use Illuminate\Http\Request;

class Furniture
{
    public function handle($request, Closure $next)
    {
        if (request()->has('is_furniture') && request()->get('is_furniture') != null) {
            return $next($request)->where('is_furniture', request()->get('is_furniture'));
        }
        return $next($request);
    }
}