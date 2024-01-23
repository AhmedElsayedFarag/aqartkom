<?php

namespace Modules\CustomerMessage\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerMessageRequest extends FormRequest
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
            'phone' => ['required', 'string', 'regex:' . config('regex_validation.phone')],
            'notes' => 'required|string|min:3|max:2000',
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
