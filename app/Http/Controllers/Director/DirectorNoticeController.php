<?php

namespace App\Http\Controllers\Director;

use App\DirectorNotice;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class DirectorNoticeController extends DirectorController 
{
	/**
	 * Get all director notices on page
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
    public function notice()
    {
        if (Gate::denies('director')) {
            return redirect()->route('admins');
        }
        $this->data['notices'] = DirectorNotice::getNotices()->paginate(15);

        return view('director.notice', $this->data);
    }

	/**
	 * Get new notices for ajax
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function getNotice()
    {
        $notice = DirectorNotice::getNotices()->where('director_notice.status', 1)->get();
        return response()->json($notice);
    }

	/**
	 * Delete new status for notice
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function deleteNotice(Request $request)
    {
        DirectorNotice::find($request->id)->update(['status' => 0]);
        return response()->json(true);
    }
}
