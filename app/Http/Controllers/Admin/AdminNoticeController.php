<?php

namespace App\Http\Controllers\Admin;

use App\AdminNotice;
use App\Avatar;
use App\DirectorEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminNoticeController extends AdminController
{
	/**
	 * Show all notices
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
	 */
    public function notice()
    {
        if (Gate::denies('admin')) {
            return redirect('/office/orders_list');
        }
        $this->data['notices'] = AdminNotice::where('admin_id', $this->idAdmin)->paginate(15);

        return view('admin.notice', $this->data);
    }

	/**
	 * Show all new notices near bell on admin layout
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function getNotice()
    {
        $notices = AdminNotice::where(['admin_id' => $this->idAdmin, 'status' => 1])->get();
        if ($notices) {
            $director_id = DirectorEmployee::where('group', 'main')->first()->user_id;
            $director_avatar = Avatar::where('user_id', $director_id)->first();

            $notices->each(function ($item) use ($director_avatar) {
                if ($item->notice_type === 'new_bill' || $item->notice_type === 'unpaid_bill') {
                    if ($director_avatar) {
                        $item->path = $director_avatar->path;
                    }
                }
            });
        }

        return response()->json($notices);
    }

	/**
	 * Change status of notice
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function deleteNotice(Request $request)
    {
        AdminNotice::find($request->id)->update(['status' => 0]);

        return response()->json(true);
    }
}
