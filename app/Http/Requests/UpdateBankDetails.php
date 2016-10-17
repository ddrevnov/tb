<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateBankDetails extends Request
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
            'account_owner'     =>  'string',
            'bank_name'         =>  'string',
            'iban'              =>  'string',
            'bic'               =>  'string',
            'legal_city'        =>  'numeric',
            'legal_state'       =>  'numeric',
            'legal_country'     =>  'numeric',
            'legal_post_index'  =>  'string',
            'legal_street'      =>  'string',
            'agreement'         =>  'boolean'
        ];
    }
}
