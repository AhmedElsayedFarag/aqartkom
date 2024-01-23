<?php

namespace Modules\Auth\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:120',
            'description' => 'required|string|min:3|max:1000',
            'city_id' => 'required|exists:cities,id',
            'commercial_register_number' => 'required|string|min:3|max:120',
            'whatsapp' => [
                'required',
                'string',
                'regex:' . config('regex_validation.phone')
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

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        str_contains($this->whatsapp, '+966') ?: $this->whatsapp = '+966' . $this->whatsapp;
        $this->merge(['whatsapp' => $this->whatsapp]);
    }
}
