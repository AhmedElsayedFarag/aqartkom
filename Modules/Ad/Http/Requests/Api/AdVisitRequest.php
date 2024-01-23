<?php

namespace Modules\Ad\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AdVisitRequest extends FormRequest
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
            'email' => 'sometimes|email',
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