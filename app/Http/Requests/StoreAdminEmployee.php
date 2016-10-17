<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreAdminEmployee extends Request
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
            'name'      =>  'required|string|max:50',
            'last_name' =>  'required|string|max:50',
            'phone'     =>  'required|digits_between:5,15',
            'email'     =>  'required|email',
            'gender'    =>  'required|string',
            'birthday'  =>  'date_format:"d/m/Y"',
            'group'     =>  'required|string',
            'status'    =>  'required|string',
            'avatar'    =>  'image'
        ];
    }
}
