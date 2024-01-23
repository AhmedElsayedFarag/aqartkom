<?php

namespace Modules\Users\Http\Requests;

use App\Helpers\AddCountryCode;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
            'city_id' => [
                'required', 'numeric', 'exists:cities,id'
            ],
            'lat'   => 'required|numeric|min:-180|max:180',
            'long'  => 'required|numeric|min:-180|max:180',
            'whatsapp_number' =>
            [
                'required',
                'string',
                "unique:company_profiles,whatsapp_number," . $this->user->id . ",user_id",
                'regex:' . config('regex_validation.phone'),
            ],
            'commercial_register_number' =>
            [
                'required',
                'string',
                "unique:company_profiles,commercial_register_number," . $this->user->id . ",user_id",
                'min:3',
                'max:120'
            ],
            'image' => 'sometimes|image|max:20480',
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