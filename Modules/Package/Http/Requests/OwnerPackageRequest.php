<?php

namespace Modules\Package\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OwnerPackageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'     => 'required|string|min:3|max:120',
            'price'     => 'required|numeric|min:1',
            'months'    => 'required|numeric|min:1|max:12',
            "ad_feature" => 'required|numeric|min:1',
            "ad_feature_ads_count" => 'required|numeric|min:1',
            "marketing_ad_by_aqaratikom" => 'required|numeric|min:1',
            // "marketing_ad_by_marketer" => 'required|numeric|min:1',
            "normal_ads" => 'required|numeric|min:1',
            'unlimited_ads' => 'required|boolean',
            // "ad_request" => 'required|numeric|min:1',
            // "contact_marketers" => 'required|numeric|min:1',
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