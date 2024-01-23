<?php

namespace Modules\Ad\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class AdFilterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type'          => 'sometimes|string|in:rent,sell',
            'prices'        => 'sometimes|array|size:2',
            'prices.0'      => 'nullable|numeric|lt:prices.1',
            'prices.1'      => 'nullable|numeric|gt:prices.0',
            'age'           => 'sometimes|array|size:2',
            'age.0'         => 'nullable|numeric|lt:age.1',
            'age.1'         => 'nullable|numeric|gt:age.0',
            'bedroom'        => 'sometimes|array|min:1',
            'area'        => 'sometimes|array|size:2',
            'area.0'      => 'nullable|numeric|lt:area.1',
            'area.1'      => 'nullable|numeric|gt:area.0',
            'category_array'      => 'sometimes|array',
            'category_array.*'      => 'nullable|numeric|exists:categories,id',
            'city'          => 'nullable|numeric|exists:cities,id',
            'neighborhood'  => 'nullable|numeric|exists:neighborhoods,id',
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