<?php

namespace Modules\Estate\Filters;

use Closure;
use Illuminate\Http\Request;
use Modules\Auth\Entities\CompanyProfile;

class CompanyFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->has('company') && request()->get('company') != null) {
            $userId = CompanyProfile::where('uuid', request()->get('company'))->first()->user_id;
            return $next($request)->where('user_id', $userId);
        }
        return $next($request);
    }
}