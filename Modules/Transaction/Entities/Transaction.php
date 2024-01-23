<?php

namespace Modules\Transaction\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Http;
use Modules\Auth\Entities\User;
use Modules\Subscription\Enums\SubscriptionStatusEnum;
use Modules\Transaction\Enums\PaymentTypeEnum;
use Illuminate\Support\Facades\Cache;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_phone',
        'amount',
        'status',
        'service_type',
        'init_data',
        'response_data',
        'inquiry_data',
        'payment_method',
        'transaction_id',
        'uuid',
        'transactionable_id',
        'transactionable_type',
        'coupon_id',
        'coupon_code',
        'coupon_discount',
        'subtotal_before_discount',
        'subtotal_after_discount',
        'vat',
        'paid_package_id',
        'paid_package_type',
    ];

    protected $casts = [
        'service_type' => PaymentTypeEnum::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactionable()
    {
        return $this->morphTo();
    }
    public function scopeSearch(Builder $builder, ?string $search = null)
    {
        return $builder->when($search, fn ($q, $search) => $q->where('customer_name', 'like', "%$search%")->orWhere('customer_phone', 'like', "%$search%"));
    }
    public function scopeStatusFilter(Builder $builder, ?string $status = null)
    {
        return $builder->when($status, fn ($q, $status) => $q->where('status', $status));
    }
    public function scopeDateRange(Builder $builder, ?string $date = null)
    {
        return $builder->when($date, fn ($q, $date) => $q->whereBetween('created_at', explode(' to ', $date)));
    }
    public function getRouteKeyName()
    {
        return 'uuid';
    }
    public function paidPackage()
    {
        return $this->morphTo('paid_package', 'paid_package_type', 'paid_package_id');
    }
    public function getPaymentType(){
       return collect(Cache::remember('payment-methods', 36000, function () {
           $service = new PaymentService();
           return $service->initiate(10);
       }))->where('id',$this->payment_method)->first();
    }
}
