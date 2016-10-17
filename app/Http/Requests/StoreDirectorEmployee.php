<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreDirectorEmployee extends Request
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
			"name"      => "required|string",
			"last_name" => "required|string",
			"phone"     => "required|string",
			"email"     => "required|email|unique:users,email",
			"gender"    => "required|in:male,female",
			"birthday"  => 'date_format:"d/m/Y"',
			"group"     => "required|in:admin,employee",
			"status"    => "required|in:active,notactive,blocked",
			"avatar"    => 'image',
		];
	}
}
