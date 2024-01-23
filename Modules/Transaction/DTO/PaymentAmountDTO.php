<?php

namespace Modules\Transaction\DTO;

use Modules\Coupon\Entities\Coupon;

class PaymentAmountDTO
{
    public ?Coupon $coupon = null;
    public function __construct(
        public float $amount,
        ?string $couponCode = null,
    ) {
        if (!is_null($couponCode))
            $this->coupon = Coupon::where('code', $couponCode)->first();
    }
    public function calculateVat()
    {

        return $this->calculateAfterDiscount() * 0.15;
    }
    public function calculateAfterDiscount()
    {
        if ($this->calculateDiscount() > $this->amount)
            return 0;
        return $this->amount - $this->calculateDiscount();
    }
    public function calculateDiscount()
    {
        if (is_null($this->coupon))
            return 0;
        if ($this->coupon->type == 'percentage')
            return $this->amount * ($this->coupon->value / 100);
        return $this->coupon->value;
    }
    public function calculateTotal()
    {
        return $this->calculateAfterDiscount() + $this->calculateVat();
    }
}
