<?php

namespace Modules\Auth\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ChangePhoneRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "phone" => ['required', 'string', 'regex:' . config('regex_validation.phone'), 'unique:users,phone', 'max:120']
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
        str_contains($this->phone, '+966') ?: $this->phone = '+966' . $this->phone;
        $this->merge(['phone' => $this->phone]);
    }
}
