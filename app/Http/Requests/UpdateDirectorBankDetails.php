<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateDirectorBankDetails extends Request
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
            'account_owner'     => 'required|string|max:50',
            'account_number'    => 'required|string|max:50',
            'bank_code'         => 'required|string',
            'bank_name'         => 'required|string',
            'iban'              => 'required|string',
            'bic'               => 'required|string',
            'ust_id'            => 'required|string',
            'trade_register'    => 'required|string',
            'tax_number'        => 'required|string',
        ];
    }
}
