<?php

namespace Modules\Estate\Filters;

use Closure;
use Illuminate\Http\Request;

class Type
{
    public function handle($request, Closure $next)
    {
        $dataTypes = [
            'rent' => 4,
            'sell' => 1
        ];


        $table = \str_contains(request()->url(), 'ad-request') ? 'ad_requests.' : 'ads.';
        if (request()->get('type') != null && is_null(request()->get('ad_type'))) {
            $type = request()->get('type');

            return $next($request)->where($table . 'type', $type);
            // ->where('ads.ad_type_id', $dataTypes[$type]);
        } else if (!is_null(request()->get('ad_type'))) {
            return $next($request)->where($table . 'ad_type_id', request()->get('ad_type'));
        }
        return $next($request);
    }
}
