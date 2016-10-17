<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateClientInfo extends Request
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
            'first_name'        => 'required|string|max:255',
            'last_name'         => 'required|string|max:255',
            'mobile'            => 'required|digits_between:5,15',
            'birthday'          => 'required|date_format:"d/m/Y"',
            'gender'            => 'required|string'
        ];
    }
}
