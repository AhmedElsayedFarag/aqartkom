<?php

namespace Modules\Auth\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UpdateCompanyRequest extends FormRequest
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
            'phone' => [
                'required',
                'string',
                'regex:' . config('regex_validation.phone')
            ],
            'email' => 'required|string|email|unique:users,email,' . auth()->id(),
            // 'commercial_register_number'  => [
            //     'required',
            //     'string',
            //     'min:3',
            //     'max:120',
            // ],
            'logo'  => [
                'nullable',
                'image',
                'max:2048'
            ],
            'description'  => [
                'required',
                'string',
                'min:3',
                'max:2000'
            ],
            'lat' => [
                'required',
                'numeric',
            ],
            'long' => [
                'required',
                'numeric',
            ],
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
