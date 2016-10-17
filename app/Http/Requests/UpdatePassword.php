<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdatePassword extends Request
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
            'old_password' => 'required|string|max:50',
            'new_password-1' => 'required|string|max:50',
        ];
    }
}
