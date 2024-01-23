<?php

namespace Modules\Auction\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BidStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount'            => 'required|numeric|min:1',
            'name'              => 'required|string|min:3|max:120',
            'phone'             => ['required', 'string', 'regex:' . config('regex_validation.phone'), 'max:120'],
            'national_number'   => 'required|string|min:3|max:120'
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

        $this->phone = \str_replace('+9665', '', $this->phone);
        $this->phone = '+9665' . $this->phone;
        $this->merge(['phone' => $this->phone]);
    }
}
