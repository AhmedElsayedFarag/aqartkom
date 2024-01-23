<?php

namespace Modules\Estate\Filters;

use Closure;
use Illuminate\Http\Request;
use Modules\Auth\Entities\CompanyProfile;
use Modules\Auth\Entities\User;

class MarketerFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->has('marketer') && request()->get('marketer') != null) {
            $userId = User::where('uuid', request()->get('marketer'))->first()->id;
            return $next($request)->where('user_id', $userId);
        }
        return $next($request);
    }
}
