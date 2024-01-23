<?php

namespace Modules\Auth\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CompanyRequest extends FormRequest
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
            // 'whatsapp_number' => [
            //     'required',
            //     'string',
            //     'regex:' . config('regex_validation.phone')
            // ],
            'commercial_register_number'  => [
                'required',
                'string',
                'min:3',
                'max:120',
            ],
            'logo'  => [
                'required',
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
