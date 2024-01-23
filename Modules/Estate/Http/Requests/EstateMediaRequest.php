<?php

namespace Modules\Estate\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstateMediaRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'media' => 'required|array',
            'media.*' => 'required|file|mimes:jpg,png,jpeg,mp4|max:10240'
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