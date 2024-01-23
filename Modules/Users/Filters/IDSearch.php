<?php

namespace Modules\Users\Filters;

use Closure;
use Illuminate\Http\Request;

class IDSearch
{
    public function handle($request, Closure $next)
    {
        if (request()->has('search')) {
            $search = request()->get('search');
            return $next($request)->orWhere('id', "%$search%");
        }
        return $next($request);
    }
}