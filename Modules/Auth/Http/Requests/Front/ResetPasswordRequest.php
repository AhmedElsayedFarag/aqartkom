<?php

namespace Modules\Auth\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => [
                'required',
                'string',
                'regex:' . config('regex_validation.phone'),
                'exists:users,phone'
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
            ],
            'code' => ['required', 'numeric', 'digits:6']
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