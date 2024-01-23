<?php


namespace Modules\Estate\Sort;

use Closure;

class Recent
{
    public function handle($request, Closure $next)
    {
        if (request()->has('sort') && request()->get('sort') == 0) {
            return $next($request)->orderByDesc('accepted_at');
        }
        if (request()->has('sort') && request()->get('sort') == 1) {
            return $next($request)->orderBy('accepted_at');
        }
        return $next($request);
    }
}