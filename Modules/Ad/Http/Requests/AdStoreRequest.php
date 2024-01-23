<?php

namespace Modules\Ad\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Estate\Entities\EstateAttribute;

class AdStoreRequest extends FormRequest
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
            'details'                   => [
                Rule::requiredIf(function () {
                    $status = EstateAttribute::where('category_id', request()->get('estate')['category'])->count() != 0;
                    return $status;
                }), 'array',
            ],
            'estate.neighborhood'       => [
                'required', 'numeric',
                Rule::exists('neighborhoods', 'id')->where(function ($query) {
                    return $query
                        ->where('city_id', request()->get('estate')['city']);
                })
            ],
            'media' => 'required|array|min:2|max:10',
            'media.*' => 'required|file|mimes:jpg,png,jpeg,mp4|max:102400',
            'price'             => 'required|numeric|min:1',
            'type'  => 'required|string|in:sell,rent',
            'instrument_number' => 'required|numeric',
            'advertiser_relation' => 'required|string|in:owner,marketer,agent',
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