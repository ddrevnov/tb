<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateAdminPersonalInfo extends Request
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
            'firstname'     =>  'required|string|max:255',
            'lastname'      =>  'required|string|max:255',
            'mobile'        =>  'required|digits_between:5,15',
            'birthday'      =>  'required|date_format:"d/m/Y"',
            'firmtype'      =>  'required|integer',
            'street'        =>  'required|string|max:255',
            'city'          =>  'required|integer',
            'state'         =>  'required|integer',
            'country'       =>  'required|integer',
            'status'        =>  'required|string'
        ];
    }
}
