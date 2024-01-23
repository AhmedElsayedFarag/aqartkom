<?php

namespace Modules\Ad\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Estate\Entities\EstateAttribute;

class AdUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // ...config('estate.media_validation_rule'),
            'media'                     => 'sometimes|array|max:15',
            'media.*'                   => 'required|string|uuid|exists:media,uuid',
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
            'price' => 'required|numeric|min:1',
            'instrument_number' => 'required|string|min:3|max:255',
            'advertiser_relation' => 'required|string|in:owner,agent,marketer'
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
