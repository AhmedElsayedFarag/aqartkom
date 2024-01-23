<?php

namespace Modules\Users\Filters;

use Closure;
use Illuminate\Http\Request;

class Search
{
    public function handle($request, Closure $next)
    {
        if (request()->has('search')) {
            $search = request()->get('search');
            return $next($request)->where('name', 'like', "%".$search."%")
                                ->orWhere('phone', 'like', "%".$search."%")
                                ->orWhere('email', 'like', "%".$search."%")
                                ->orWhere('id',$search);
        }
        return $next($request);
    }
}