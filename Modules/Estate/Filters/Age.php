<?php

namespace Modules\Estate\Filters;

use Closure;
use Illuminate\Http\Request;

class Age
{
    public function handle($request, Closure $next)
    {
        if (request()->has('age') && request()->get('age') != null) {
            return $next($request)->whereBetween('age', request()->get('age'));
        }
        return $next($request);
    }
}