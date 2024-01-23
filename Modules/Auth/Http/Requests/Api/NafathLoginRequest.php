<?php

namespace Modules\Auth\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NafathLoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'national_number' => 'required|digits:10|exists:users,nationality_id',
            'mobile_token' => [
                Rule::requiredIf(function () {
                    return $this->get('source') != 'web';
                }), 'string', 'min:3', 'max:255'
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
