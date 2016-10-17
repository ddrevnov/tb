<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreNewAdmin extends Request
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
	        'firstname' =>  'required|string|max:50',
	        'lastname'  =>  'required|string|max:50',
	        'firmlink'  =>  'required|string|max:50',
	        'telnumber' =>  'required|digits_between:5,15',
	        'email'     =>  'required|email',
	        'gender'    =>  'required|string',
	        'birthday'  =>  'date_format:"d/m/Y"',
	        'status'    =>  'required|string',
	        'avatar'    =>  'image',
	        'tariff'    =>  'required',
	        'firmtype'  =>  'required'
        ];
    }
}
