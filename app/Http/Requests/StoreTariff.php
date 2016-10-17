<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreTariff extends Request
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
            'name' => 'required|string|max:255',
            'type' => 'in:free,paid',
            'status' => 'required|boolean',
            'price' => 'numeric',
            'duration' => 'required|integer',
            'description'   =>  'required|string',
            'letters_count' => 'integer',
            'letters_unlimited' => 'boolean',
            'employee_count' => 'integer',
            'employee_unlimited' => 'boolean',
            'services_count' => 'integer',
            'services_unlimited' => 'boolean',
            'dashboard_count' => 'integer',
            'dashboard_unlimited' => 'boolean',
        ];
    }
}
