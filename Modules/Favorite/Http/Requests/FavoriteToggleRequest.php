<?php

namespace Modules\Favorite\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FavoriteToggleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required|string|in:ad,company,auction',
            'id' => 'required|string|uuid',
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