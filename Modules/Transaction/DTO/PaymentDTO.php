<?php

namespace Modules\Transaction\DTO;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Transaction\Contracts\IPaidPackage;
use Modules\Transaction\Enums\PaymentTypeEnum;
use Illuminate\Support\Str;

class PaymentDTO
{
    public function __construct(
        public string $customerName,
        public string $customerPhone,
        public string $customerEmail,
        public PaymentTypeEnum $paymentType,
        public int $paymentMethodId,
        public Model|Authenticatable $model,
        public PaymentAmountDTO $paymentAmountDTO,
        public ?IPaidPackage $paidPackage = null,
    ) {
    }
    public function toArray(): array
    {
        return [
            'user_id' => auth()->id(),
            'service_type' => $this->paymentType,
            'customer_name' => $this->customerName,
            'customer_phone' => $this->customerPhone,
            'amount' => $this->paymentAmountDTO->calculateTotal(),
            'transaction_id' => Str::random(10),
            'uuid' => Str::uuid(),
            'payment_method' => $this->paymentMethodId,
            'transactionable_id' => $this->model->id,
            'transactionable_type' => \get_class($this->model),
            'coupon_id' => $this->paymentAmountDTO->coupon?->id,
            'coupon_code' => $this->paymentAmountDTO->coupon?->code,
            'coupon_discount' => $this->paymentAmountDTO->calculateDiscount(),
            'subtotal_before_discount' => $this->paymentAmountDTO->amount,
            'subtotal_after_discount' => $this->paymentAmountDTO->calculateAfterDiscount(),
            'vat' => $this->paymentAmountDTO->calculateVat(),

        ];
    }
}