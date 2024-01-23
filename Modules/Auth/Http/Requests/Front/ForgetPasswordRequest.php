<?php

namespace Modules\Auth\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class ForgetPasswordRequest extends FormRequest
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
                'required', 'string', 'exists:users,phone', 'regex:' . config('regex_validation.phone')
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
