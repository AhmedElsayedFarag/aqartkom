<?php

namespace Modules\Category\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeaturedCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type'          => 'required|string|in:sell,rent',
            'title'          => 'required|string|min:3|max:120',
            'background'    => 'required|image|max:20480',
            'city_id'       => 'required|numeric|exists:cities,id',
            'category_id'   => 'required|numeric|exists:categories,id',
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