<?php

namespace Modules\Category\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:120',
            'is_building' => 'sometimes|boolean',
            'is_price_per_meter' => 'sometimes|boolean',
            'is_bedroom_enable' => 'sometimes|boolean',
            'icon' => 'required|image|max:20480',
            'background' => 'required|image|max:20480',
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