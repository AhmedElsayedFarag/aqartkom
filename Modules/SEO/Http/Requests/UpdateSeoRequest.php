<?php

namespace Modules\SEO\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSeoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'og:title' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'og:type' => 'required|string|max:255',
            'og:url' => 'required|string|max:255',
            'og:description' => 'required|string|max:255',
            'og:image:alt' => 'required|string|max:255',
            // 'og:image' => 'required|image',
            'og:site_name' => 'required|string|max:255',
            'og:locale' => 'required|string|max:255',
            'article:author' => 'required|string|max:255',
            'twitter:card' => 'required|string|max:255',
            'twitter:site' => 'required|string|max:255',
            'twitter:creator' => 'required|string|max:255',
            'twitter:url' => 'required|string|max:255',
            'twitter:title' => 'required|string|max:255',
            'twitter:description' => 'required|string|max:255',
            // 'twitter:image' => 'required|image',
            'twitter:image:alt' => 'required|string|max:255',
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