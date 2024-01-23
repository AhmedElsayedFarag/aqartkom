<?php

namespace Modules\Package\Http\Controllers\Front;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Services\CouponService;
use Modules\Package\Entities\Package;
use Modules\Package\Services\Api\PackageService;
use Modules\Package\Transformers\PackageResource;
use Modules\Subscription\Services\SubscriptionService;
use Modules\Subscription\Transformers\SubscriptionShowResource;
use Modules\Transaction\DTO\PaymentAmountDTO;
use Modules\Transaction\DTO\PaymentDTO;
use Modules\Transaction\Enums\PaymentTypeEnum;
use Modules\Transaction\Services\PaymentService;

class PayPackageController extends Controller
{
    public function __construct(public SubscriptionService $service)
    {
    }
    public function showPaymentForm(Package $package)
    {
        return view('package::pay-package', compact('package'));
    }
    public function payPackage(Request $request, Package $package)
    {
        $link = DB::transaction(function () use ($request, $package) {
            $paymentService = new PaymentService();

            if ($request->has('coupon')) {
                $coupon = Coupon::where('code', $request->coupon)->first();
                CouponService::validate($coupon);
            }
            $amountDto = new PaymentAmountDTO($package->price, $request->get('coupon'));
            $paymentDto = new PaymentDTO(
                auth()->user()->name,
                auth()->user()->phone,
                auth()->user()->email,
                PaymentTypeEnum::AdFeature,
                $request->payment_method,
                auth()->user(),
                $amountDto,
                $package
            );
            return $paymentService->createLink($paymentDto);
        });
        if (strlen($link))
            return redirect()->away($link);
        return redirect()->route('front.profile.subscription.show');
    }
}