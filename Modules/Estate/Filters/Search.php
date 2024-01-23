<?php

namespace Modules\Estate\Filters;

use Closure;
use Illuminate\Http\Request;

class Search
{
    public function handle($request, Closure $next)
    {
        if (request()->has('search') && request()->get('search') != null) {
            return $next($request)->where('title', 'like', '%' . request()->get('search') . '%');
        }
        return $next($request);
    }
}