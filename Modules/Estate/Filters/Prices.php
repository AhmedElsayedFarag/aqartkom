<?php

namespace Modules\Estate\Filters;

use Closure;
use Illuminate\Http\Request;

class Prices
{
    public function handle($request, Closure $next)
    {
        if (request()->has('prices') && request()->get('prices')[0] != null && request()->get('prices')[1] != null) {
            $prices = request()->get('prices');
            return $next($request)->whereBetween('price', [intval($prices[0]), intval($prices[1])]);
        }
        return $next($request);
    }
}