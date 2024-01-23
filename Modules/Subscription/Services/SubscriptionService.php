<?php

namespace Modules\Subscription\Services;

use App\DataTransferObjects\QrcodeDto;
use App\Exceptions\NoActiveSubscriptionException;
use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Entities\User;

use Modules\Subscription\Entities\Subscription;
use Modules\Subscription\Enums\SubscriptionStatusEnum;
use Modules\Subscription\Http\Requests\StoreSubscriptionRequest;
use Illuminate\Support\Str;
use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Services\CouponService;
use Modules\Package\Entities\Package;
use Modules\Subscription\Http\Requests\SubscriptionRequest;
use Modules\Transaction\DTO\PaymentAmountDTO;
use Modules\Transaction\DTO\PaymentDTO;
use Modules\Transaction\Enums\PaymentTypeEnum;
use Modules\Transaction\Services\PaymentService;

class SubscriptionService
{
    /**
     * User subscription.
     *
     * @param  \Modules\Auth\Entities\User  $user
     * @param  \Modules\Subscription\Entities\Package  $package
     * @return \Modules\Subscription\Entities\Subscription
     */
    public static function subscribe(User $user, Package $package)
    {
        if ($currentSubscription = $user->activeSubscription()) {
            self::changeState($currentSubscription, SubscriptionStatusEnum::SUSPENDED);
        }
        $subscription = $user->subscriptions()->create([
            'status' => SubscriptionStatusEnum::PENDING,
            'start_at' => now(),
            'end_at' => $package->type == 'monthly' ? now()->addMonth(1) : now()->addYear(1)
        ]);

        $subscription->package()->associate($package);
        return $subscription;
    }

    /**
     * Change subscription status
     *
     * @param  \Modules\Subscription\Entities\Subscription $subscription
     * @param  String $state
     * @return Boolean
     */
    public static function changeState(Subscription &$subscription, $state)
    {
        $changed = $subscription->update(['status' => $state]);
        $subscription->refresh();
        return $changed;
    }
    public function create(StoreSubscriptionRequest $request)
    {
        \abort_if(auth()->user()->type != 'company', 404);
        \abort_if(!is_null(auth()->user()->companyProfile), 404);
        $uuid = Str::uuid();
        $request->merge([
            'logo' => $request->file('image')->store('', ['disk' => 'companies']),
            'uuid' => $uuid,
            'whatsapp_number' => $request->get('whatsapp'),
            'qr_code' => create_qr_code(new QrcodeDto(
                route('front.companies.show', ['company' => $uuid]),
                'companies'
            ))
        ]);
        DB::transaction(function () use ($request) {
            auth()->user()->companyProfile()->create($request->all());
            $package = Package::find($request->get('package'));
            Subscription::create([
                'user_id' => auth()->id(),
                'package_id' => $package->id,
                'package_name' => $package->title,
                'user_name' => auth()->user()->name,
                'user_phone' => auth()->user()->phone,
                'status' => 'approved',
                'start_at' => now()->toDateString(),
                'end_at' => now()->addMonths($package->months)->toDateString(),
            ]);
        });
    }
    public function createOwner(SubscriptionRequest $request)
    {
        $package = Package::find($request->get('package'));
        abort_if($package->user_type != auth()->user()->type, 422, __('messages.package_not_found'));
        if ($request->has('coupon')) {
            $coupon = Coupon::where('code', $request->coupon)->where('usage', 'packages')->first();
            CouponService::validate($coupon);
        }
        $amountDto = new PaymentAmountDTO($package->price, $request->coupon);
        $paymentDto = new PaymentDTO(
            auth()->user()->name,
            auth()->user()->phone,
            auth()->user()->email,
            PaymentTypeEnum::Subscription,
            $request->payment_method,
            auth()->user(),
            $amountDto,
            $package
        );
        $service = new PaymentService();
        return $service->createLink($paymentDto);
    }

    public static function getActiveSubscription(?int $userID = null): Subscription|null
    {
        if (is_null($userID))
            $userID = \auth()->id();
        return  Subscription::query()->with(['features'])->where('user_id', $userID)->status('approved')->first();
    }

    public static function checkHasActiveSubscription()
    {
        $subscription = static::getActiveSubscription();
        if (is_null($subscription)) {
            throw new NoActiveSubscriptionException();
        }
    }
    public static function formatFeatures($features)
    {
        // dd($features);
        return $features->map(function ($feature) {
            $data =
                [
                    'title' => $feature->feature_title,
                    'start_count' => \get_arabic_number($feature->start_count),
                    'used_count' => \get_arabic_number($feature->start_count - $feature->remaining_count),
                    'remaining_count' => \get_arabic_number($feature->remaining_count),
                    'days' => '-',
                    'type' => $feature->feature_type->value,
                    'not_formatted_remaining' => (int)$feature->remaining_count,
                ];
            if ($feature->feature_type->value == 'ad_feature')
                $data['days'] = \get_arabic_number($feature->feature_value['days']);
            return $data;
        });
    }
    public function cancel()
    {
        static::checkHasActiveSubscription();
        $subscription = static::getActiveSubscription();
        $subscription->update([
            'status' => 'canceled',
        ]);
    }
}