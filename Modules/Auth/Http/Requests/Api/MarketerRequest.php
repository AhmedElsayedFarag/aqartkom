<?php

namespace Modules\Auth\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class MarketerRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' =>
            [
                'required',
                'string',
                'min:3',
                'max:120',
            ],
            'whatsapp_number' => [
                'required_if:type,marketer,company',
                'string',
                'regex:' . config('regex_validation.phone')
            ],
            'advertisement_number' => [
                'required_if:type,marketer',
                'string',
                'min:3',
                'max:120',
            ],
            'advertisement_type' => 'nullable|string|in:mediator,advertiser,marketer'
        ];
    }


    // /**
    //  * Prepare the data for validation.
    //  *
    //  * @return void
    //  */
    // protected function prepareForValidation()
    // {
    //     str_contains($this->phone, '+966') ?: $this->phone = '+966' . $this->phone;
    //     $this->merge(['phone' => $this->phone]);
    // }
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
