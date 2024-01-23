<?php

namespace Modules\Users\Http\Requests;

use App\Helpers\AddCountryCode;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMarketerRequest extends FormRequest
{
    use AddCountryCode;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'name' =>
            [
                'required',
                'string',
                'min:3',
                'max:120',
            ],
            'email' =>
            [
                'required',
                'email',
                'unique:users,email,' . $this->user->id,
            ],

            'phone' =>
            [
                'required',
                'string',
                'unique:users,phone,' . $this->user->id,
                'regex:' . config('regex_validation.phone'),
            ],
            'whatsapp_number' =>
            [
                'required',
                'string',
                "unique:marketer_profiles,whatsapp_number," . $this->user->id . ",user_id",
                'regex:' . config('regex_validation.phone'),
            ],
            'advertisement_number' =>
            [
                'required',
                'string',
                "unique:marketer_profiles,advertisement_number," . $this->user->id . ",user_id",
                'min:3',
                'max:120'
            ],
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