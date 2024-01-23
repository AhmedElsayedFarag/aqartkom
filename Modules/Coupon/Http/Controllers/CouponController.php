<?php

namespace Modules\Coupon\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Services\CouponService;
use Modules\Coupon\Transformers\CouponResource;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        Validator::make($request->all(), [
            'coupon' => ['required', 'string', 'min:3', 'max:255'],
            'type' => 'required|string|in:package,service',
        ]);

        $coupon = Coupon::where('code', $request->coupon)->where('usage', $request->type . 's')->first();
        CouponService::validate($coupon);
        return new CouponResource($coupon);
    }
}