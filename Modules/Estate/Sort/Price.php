<?php


namespace Modules\Estate\Sort;

use Closure;

class Price
{
    public function handle($request, Closure $next)
    {
        // if (request()->has('sort')) {
        //     if (request()->get('sort') == 1) {
        //         return $next($request)->orderByDesc('price');
        //     } else if (request()->get('sort') == 2) {
        //         return $next($request)->orderBy('price');
        //     }
        // }

        return $next($request);
    }
}