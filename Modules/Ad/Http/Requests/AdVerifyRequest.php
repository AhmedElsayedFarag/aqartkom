<?php

namespace Modules\Ad\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Estate\Entities\EstateAttribute;

class AdVerifyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'licenceNumber' => ['required'],
            'advertiserId' => ['required']
        ];
    }

    public function attributes()
    {
        return [
            'licenceNumber' => __('admin.licenceNumber'),
            'advertiserId' => __('admin.advertiserId')
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
