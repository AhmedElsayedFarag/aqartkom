<?php


namespace Modules\Estate\Sort;

use Closure;

class Age
{
    public function handle($request, Closure $next)
    {
        if (request()->has('sort') && request()->get('sort') == 4) {
            return $next($request)->orderByDesc('age');
        }
        return $next($request);
    }
}