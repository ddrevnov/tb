<?php

namespace App\Traits;

use App\Http\Requests\StoreLogo;

trait StoreLogoTrait
{
	/**
	 * Upload firm logo
	 *
	 * @param StoreLogo $request
	 */
	public function uploadLogo($request)
	{
		if ($request->hasFile('firm_logo')){
			$logo = $request->file('firm_logo');
			$path = '/images/logos/';
			$fileName = str_random(8) . $logo->getClientOriginalName();
			$fullPath = public_path() . $path;
			$logo->move($fullPath, $fileName);

			return $path . $fileName;
		}
		return false;
	}
}