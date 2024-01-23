<?php

namespace Modules\Auction\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuctionFilterRequest extends FormRequest
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
            'closed' => 'sometimes|boolean',
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