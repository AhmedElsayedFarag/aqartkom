<?php

namespace Modules\Mortgage\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MortgageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'nationality' => 'required|string|min:3|max:255',
            'email' =>
            [
                'required',
                'email',
            ],

            'phone' =>
            [
                'required',
                'string',
                'regex:' . \config('regex_validation.phone'),
            ],
            'gender' => 'required|string|in:male,female',
            'age' => 'required|numeric|min:0|max:' . (count(__('mortgage.age')) - 1),
            'bank' => 'required|numeric|min:0|max:' . (count(__('mortgage.bank')) - 1),
            'group' => 'required|numeric|min:0|max:' . (count(__('mortgage.group')) - 1),
            'salary' => 'required|numeric|min:0|max:' . (count(__('mortgage.salary')) - 1),
            'area' => 'required|numeric|min:0|max:' . (count(__('mortgage.area')) - 1),
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
