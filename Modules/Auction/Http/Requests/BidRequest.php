<?php

namespace Modules\Auction\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BidRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:120'],
            'phone' => ['required', 'string', 'regex:' . config('regex_validation.phone')],
            'amount' => ['required', 'numeric', 'min:1'],
            'national_number' => ['required', 'string'],
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
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        str_contains($this->phone, '+966') ?: $this->phone = '+966' . $this->phone;
        $this->merge(['phone' => $this->phone]);
    }
}