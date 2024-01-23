<?php

namespace Modules\Users\Filters;

use Closure;
use Illuminate\Http\Request;

class CompanySearch
{
    public function handle($request, Closure $next)
    {
        if (request()->has('search')) {
            $search = request()->get('search');
            return $next($request)->where('company_profiles.name', 'like', "%$search%");
        }
        return $next($request);
    }
}
