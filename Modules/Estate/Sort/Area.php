<?php


namespace Modules\Estate\Sort;

use Closure;

class Area
{
    public function handle($request, Closure $next)
    {
        if (request()->has('sort')) {
            if (request()->get('sort') == 2) {
                return $next($request)->orderByDesc('area');
            } else if (request()->get('sort') == 3) {
                return $next($request)->orderBy('area');
            }
        }

        return $next($request);
    }
}