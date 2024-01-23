<?php

namespace Modules\Coupon\Services;

use Illuminate\Support\Carbon;
use Modules\Coupon\Entities\Coupon;

class CouponService
{
    public function __construct()
    {
    }
    public static function validate(?Coupon $coupon = null)
    {
        \abort_if(is_null($coupon), 422, __('messages.coupon_not_found'));
        \abort_if($coupon->is_active == 0, 422, __('messages.coupon_not_active'));

        $now = Carbon::now();
        \abort_if(!$now->between($coupon->start_at, $coupon->expire_at), 422, __('messages.coupon_expired'));

        \abort_if(($coupon->max_use <= $coupon->current_usage) && ($coupon->current_usage != 0), 422, __('messages.coupon_expired'));
    }
}