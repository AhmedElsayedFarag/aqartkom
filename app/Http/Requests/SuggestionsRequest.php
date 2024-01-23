<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuggestionsRequest extends FormRequest
{
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {

        $this->phone = '+966' . $this->phone;
        $this->phone = \str_replace('+96605', '+9665', $this->phone);
        $this->merge(['phone' => $this->phone]);
    }
}
