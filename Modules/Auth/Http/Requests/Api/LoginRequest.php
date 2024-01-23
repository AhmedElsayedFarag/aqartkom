<?php

namespace Modules\Auth\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
                'regex:' . config('regex_validation.phone')
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'max:120'
            ],

            'mobile_token' => [
                'nullable',
                'string',
                'max:200'
            ],
        ];
    }

    /**

     * .
     * @return array
     */
    public function credentials()
    {
        return $this->only(['phone', 'password']);
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
