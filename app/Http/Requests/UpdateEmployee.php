<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateEmployee extends Request
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
            'gender'    =>  'required|in:male,female',
            'birthday'  =>  'date_format:"d/m/Y"',
            'group'     =>  'required|string',
            'status'    =>  'required|string',
            'avatar'    =>  'image',
        ];
    }
}
