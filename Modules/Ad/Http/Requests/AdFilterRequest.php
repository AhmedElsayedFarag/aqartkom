<?php

namespace Modules\Ad\Http\Requests;

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
            'search' => 'sometimes|string|min:3|max:120',
            'city'  => 'sometimes|numeric|exists:cities,id',
            'status' => 'sometimes|string|in:pending,approved,cancelled,closed',
            'type'  => 'sometimes|string|in:sell,rent',
            'ad_type'  => 'sometimes|numeric|exists:ad_types,id',
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