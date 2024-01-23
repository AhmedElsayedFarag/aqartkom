<?php

namespace Modules\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AdminRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
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
                'max:120',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
            ]
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
