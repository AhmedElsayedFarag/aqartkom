<?php

namespace Modules\Ad\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdMapFilterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            ...config('estate.filter_validation_rules'),
            "center"        => 'required|array|size:2',
            'center.lat'    => ['required', 'numeric', 'min:-180', 'max:180'],
            'center.long'    => ['required', 'numeric', 'min:-180', 'max:180'],
            "second_point"        => 'required|array|size:2',
            'second_point.lat'    => ['required', 'numeric', 'min:-180', 'max:180'],
            'second_point.long'    => ['required', 'numeric', 'min:-180', 'max:180'],

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