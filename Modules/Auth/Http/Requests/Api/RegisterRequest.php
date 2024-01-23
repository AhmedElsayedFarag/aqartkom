<?php

namespace Modules\Auth\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
            'email' =>
            [
                'required',
                'email',
                'unique:users,email'
            ],

            'phone' =>
            [
                'required',
                'string',
                'unique:users,phone',
                'regex:' . config('regex_validation.phone'),
            ],
            'password' =>
            [
                'required',
                'string',
                'confirmed',
                'min:8',
                'max:120',
                // Password::min(8)
                //     ->letters()
                //     ->mixedCase()
                //     ->numbers()
                // ->symbols()
                // ->uncompromised()
            ],
            'type' => [
                'required',
                'string',
                'in:marketer,customer,owner,company'
            ],

            'otp' => [
                'required',
                'numeric',
                'digits:6'
            ],
            'mobile_token' => [
                'nullable',
                'string',
                'min:8',
                'max:200',
            ],
            'profile' => [
                'nullable',
                'image',
                'max:2048',
            ],
            'advertisement_number' => [
                // 'required_if:type,marketer',
                Rule::requiredIf(function () {
                    return $this->type == 'marketer' ;
                    // || $this->type == 'company';
                }),
                Rule::when(function () {
                    return $this->type == 'marketer';
                }, function () {
                    return [
                        'regex:/^(11)\d{8,20}$/'
                    ];
                }),
                Rule::when(function () {
                    return $this->type == 'company';
                }, function () {
                    return [
                        'regex:/^(12)\d{8,20}$/'
                    ];
                }),
                'string',
                'min:3',
                'max:120',
            ],
            'advertisement_type' => 'nullable|string|in:mediator,advertiser,marketer',
            // 'city_id' => [
            //     Rule::requiredIf(function () {
            //         return $this->type == 'marketer' || $this->type == 'company';
            //     }),
            //     'nullable',
            //     'numeric',
            //     'exists:cities,id'
            // ],
            // 'whatsapp_number' => [
            //     'required_if:type,marketer,company',
            //     'string',

            //     'regex:' . config('regex_validation.phone')
            // ],
            // 'advertisement_number' => [
            //     'required_if:type,marketer',
            //     'string',
            //     'min:3',
            //     'max:120',
            // ],
            // 'company_name' => [
            //     'required_if:type,company',
            //     'string',
            //     'min:3',
            //     'max:120',
            // ],
            // 'commercial_register_number'  => [
            //     'required_if:type,company',
            //     'string',
            //     'min:3',
            //     'max:120',
            // ],
            'logo'  => [

                'required_if:type,company',
                'image',
                'max:10240'
            ],
            'description'  => [

                'required_if:type,company',
                'string',
                'min:3',
                'max:2000'
            ],
            'lat' => [

                'required_if:type,company',
                'numeric',
            ],
            'long' => [
                'required_if:type,company',
                'numeric',
            ],
        ];
    }

    /**
     * Merge hashed password & return request data.
     * @return array
     */
    public function credentials()
    {
        return $this->merge(['password' => Hash::make($this->password)])->all();
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