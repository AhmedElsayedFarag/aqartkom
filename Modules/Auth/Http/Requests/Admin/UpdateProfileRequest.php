<?php

namespace Modules\Auth\Http\Requests\Admin;

use App\Helpers\AddCountryCode;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:120',
            'email' => 'required|string|email|unique:users,email,' . auth()->id(),
            'phone' =>
            [
                'required',
                'string',
                'unique:users,phone,' . auth()->id(),
                'regex:' . config('regex_validation.phone'),
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