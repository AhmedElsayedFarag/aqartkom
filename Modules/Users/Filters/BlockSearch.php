<?php

namespace Modules\Users\Filters;

use Closure;
use Illuminate\Http\Request;

class BlockSearch
{
    public function handle($request, Closure $next)
    {
        if (request()->has('status')) {
            $search = request()->get('status');
            return $next($request)->where('is_blocked' , !$search);
        }
        return $next($request);
    }
}