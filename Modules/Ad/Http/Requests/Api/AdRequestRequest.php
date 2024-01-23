<?php

namespace Modules\Ad\Http\Requests\Api;

use Illuminate\Validation\Rule;
use Modules\Estate\Entities\EstateAttribute;
use Illuminate\Foundation\Http\FormRequest;

class AdRequestRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            ...config('estate.validation_rules'),
            'estate.neighborhood'       => [
                'required', 'numeric',
                Rule::exists('neighborhoods', 'id')->where(function ($query) {
                    return $query
                        ->where('city_id', request()->get('estate')['city']);
                })
            ],
            'details'                   => [
                Rule::requiredIf(function () {
                    $status = EstateAttribute::where('category_id', request()->get('estate')['category'])->count() != 0;
                    return $status;
                }), 'array',
            ],
            'price'             => 'required|numeric|min:1',
            'type'              => 'required|string|in:rent,sell',
            'type_id'           => 'required|numeric|exists:ad_types,id'
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

    public function prepareForValidation()
    {
        if ($this->type === 'sell' && is_null($this->type_id)) {
            $this->merge([
                'type_id' => 1
            ]);
        }
        if ($this->type == 'rent' && is_null($this->type_id)) {
            $this->merge([
                'type_id' => 4
            ]);
        }
    }
}