<?php

namespace Modules\Coupon\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => ['required' , 'string' , 'max:255'],
            'type' => ['required'],
            'value' => ['required' , 'numeric'],
            'max_use' => ['required' , 'numeric'],
            'start_at' => ['required' , 'date'],
            'expire_at' =>['required' , 'date' , 'after:start_at'],
            'usage' => ['required' , 'not_in:0'],
            'commission' => ['required' , 'not_in:0']
        ];

        if ($this->routeIs('dashboard.coupon.store')) {
            $rules['code'] = ['required' , 'unique:coupons,code'];
        }else{
            $coupon = $this->coupon;
            $rules['code'] = ['required' , 'unique:coupons,code,'.$coupon->id];
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => __('validation.attributes.coupon.name'),
            'type' => __('validation.attributes.coupon.type'),
            'value' => __('validation.attributes.coupon.value'),
            'max_use' => __('validation.attributes.coupon.max_use'),
            'start_at' => __('validation.attributes.coupon.start_at'),
            'expire_at' => __('validation.attributes.coupon.expire_at'),
            'code' => __('validation.attributes.coupon.code'),
            'usage' => __('validation.attributes.coupon.usage'),
            'commission' => __('validation.attributes.coupon.commission'),
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
