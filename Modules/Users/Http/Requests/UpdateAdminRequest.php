<?php

namespace Modules\Users\Http\Requests;

use App\Helpers\AddCountryCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Modules\Auth\Entities\User;

class UpdateAdminRequest extends FormRequest
{
    use AddCountryCode;
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
                'unique:users,email,' . $this->user->id
            ],

            'phone' =>
            [
                'required',
                'string',
                'unique:users,phone,' . $this->user->id,
                'regex:' . config('regex_validation.phone'),
            ],
            'roles' => 'required|array',
            'roles.*' => 'required|numeric'
            // 'password' =>
            // [
            //     'nullable',
            //     'string',
            //     'max:120',
            //     Password::min(8)
            //         ->letters()
            //         ->mixedCase()
            //         ->numbers()
            // ]
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