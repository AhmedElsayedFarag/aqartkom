<?php

namespace Modules\Users\Filters;

use Closure;
use Illuminate\Http\Request;

class AccountSearch
{
    public function handle($request, Closure $next)
    {
        if (request()->has('account')) {
            $search = request()->get('account');
            return $next($request)->where('is_authorized' , $search);
        }
        return $next($request);
    }
}