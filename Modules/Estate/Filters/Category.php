<?php

namespace Modules\Estate\Filters;

use Closure;
use Illuminate\Http\Request;

class Category
{
    public function handle($request, Closure $next)
    {
        if (request()->has('category') && request()->get('category') != null) {
            return $next($request)->where('category_id', request()->get('category'));
        }
        if (request()->has('category_array') && request()->get('category_array')[0] != null) {
            return $next($request)->whereIn('category_id', request()->get('category_array'));
        }
        return $next($request);
    }
}