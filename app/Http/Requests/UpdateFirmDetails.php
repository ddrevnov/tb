<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateFirmDetails extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firm_name'         => 'required|string|max:255',
            'firm_telnumber'    => 'required|string|max:255',
            'street'            => 'required|string|max:255',
            'post_index'        => 'required|integer|digits_between:5,10',
            'state'             => 'required|integer',
            'city'              => 'required|integer',
            'country'           => 'required|integer'
        ];
    }
}
