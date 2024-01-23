<?php

namespace Modules\Setting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppSettingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'app_store'  => 'required|string|url|max:220',
            'google_play'  => 'required|string|url|max:220',
            'app_popup_link'  => 'nullable|string|url|max:220',
            'image'  => 'sometimes|file|image|max:10240',
            'app_popup'  => 'sometimes|file|image|max:10240',
            'app_version' => 'required|string|min:3|max:10'
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
