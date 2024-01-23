<?php

namespace Modules\Ad\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdUserFilterRequest extends FormRequest
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
            'center.lat'    => [Rule::requiredIf($this->has('center')), 'numeric'],
            'center.long'    => [Rule::requiredIf($this->has('center')), 'numeric'],
            "second_point"        => 'sometimes|array|size:2',
            'second_point.lat'    => [Rule::requiredIf($this->has('second_point')), 'numeric'],
            'second_point.long'    => [Rule::requiredIf($this->has('second_point')), 'numeric'],

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