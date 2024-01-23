<?php

namespace Modules\Setting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactUsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone'     => ['required', 'string', 'regex:' . config('regex_validation.phone')],
            'whatsapp'  => ['required', 'string', 'regex:' . config('regex_validation.phone')],
            'facebook'  => 'required|string|url|max:200',
            'twitter'   => 'required|string|url|max:200',
            'instagram' => 'required|string|url|max:200',
            'linkedin'  => 'required|string|url|max:200',
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