<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StartAssistant extends Request
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
            'firstname'         =>  'required|string|max:50',
            'lastname'          =>  'required|string|max:50',
            'mobile'            =>  'digits_between:5,15',
            'gender'            =>  'required|in:male,female',
            'telnumber'         =>  'digits_between:5,15',
            'email'             =>  'required|email',
            'firmname'          =>  'string',
            'firm_name'         =>  'required|string',
            'city'              =>  'required|numeric',
            'state'             =>  'required|numeric',
            'country'           =>  'required|numeric',
            'post_index'        =>  'required|string',
            'street'            =>  'required|string',
            'firmtype'          =>  'required|string',
            'legal_city'        =>  'numeric',
            'legal_state'       =>  'numeric',
            'legal_country'     =>  'numeric',
            'legal_post_index'  =>  'string',
            'legal_street'      =>  'string',
            'iban'              =>  'string',
            'bic'               =>  'string',
            'bank_name'         =>  'string',
            'account_owner'     =>  'string',
            'aggrement'         =>  'boolean',
            'birthday'          =>  'required'
        ];
    }
}
