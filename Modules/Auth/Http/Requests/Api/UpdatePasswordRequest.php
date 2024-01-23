<?php

namespace Modules\Auth\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old' => 'required|string|max:120',
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