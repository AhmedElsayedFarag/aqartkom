<?php

namespace Modules\Auction\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Estate\Entities\EstateAttribute;
use Illuminate\Foundation\Http\FormRequest;

class StoreAuctionRequest extends FormRequest
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
            'media' => 'required|array|min:2|max:10',
            'media.*' => 'required|file|mimes:jpg,png,jpeg,mp4|max:30720',
            'initial_price' => 'required|numeric|min:1',
            'end_at'  => 'required|date|after:tomorrow',
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
