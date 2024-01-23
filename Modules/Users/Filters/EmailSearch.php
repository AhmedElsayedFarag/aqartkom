<?php

namespace Modules\Users\Filters;

use Closure;
use Illuminate\Http\Request;

class EmailSearch
{
    public function handle($request, Closure $next)
    {
        if (request()->has('search')) {
            $search = request()->get('search');
            return $next($request)->orWhere('email', 'like',"%".$search."%");
        }
        return $next($request);
    }
}