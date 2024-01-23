<?php

namespace Modules\Ad\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAgeFilterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'values' => 'required|array|min:1',
            'values.*.name' => 'required|string|min:3|max:120',
            'values.*.values' => 'required|array|size:2',
            'values.*.values.0' => 'required|numeric|lt:values.*.values.1|distinct',
            'values.*.values.1' => 'required|numeric|gt:values.*.values.0|distinct',
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

    public function messages()
    {
        return [
            'values.*.values.0.lt' => 'يجب ان تكون القيمة اقل ',
            'values.*.values.1.gt' => 'يجب ان تكون القيمة اكبر ',
            'values.*.values.*.distinct' => 'للحقل قيمة مكررة'
        ];
    }
}