<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateDirectorLegalAddress extends Request
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
            'firm_name'         => 'required|string|max:50',
            'first_last_name'   => 'required|string|max:50',
            'post_index'        => 'required|string',
            'street'            => 'required|string',
            'addition_address'  => 'string',
        ];
    }
}
