<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Slider;
use Illuminate\Support\Facades\Gate;

class AdminSliderController extends AdminController
{
	/**
	 * Page with all admin slides
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
	 */
    public function slider()
    {
        if (Gate::denies('admin')) {
            return redirect('/office/orders_list');
        }

        $this->data['slidersList'] = $this->admin->slides;

        return view('admin.slider', $this->data);
    }

	/**
	 * Page for create new admin slide
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
	 */
    public function slider2()
    {
        if (Gate::denies('admin')) {
            return redirect('/office/orders_list');
        }
        return view('admin.slider2', $this->data);
    }

	/**
	 * Upload new slide or edit old
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
    public function uploadSlide(Request $request)
    {
        if (Gate::denies('admin')) {
            return redirect('/office/orders_list');
        }

        $slide = $request->file('image');
        $slideName = $request['slide_name'];
        $slideStatus = $request->slide_status ? 1 : 0;

        if ($request->hasFile('image')) {

            $path = '/sliders/' . $this->idAdmin;
            $image = str_random(8) . $slide->getClientOriginalName();
            $fullPath = public_path() . '/images' . $path;
            $slide = $slide->move($fullPath . '/', $image);

            self::resizeSlide($slide, $fullPath . '/' . $image);
            if ($request->slide_edit_id) {
                Slider::updateSlide($request->slide_edit_id, $slideName, $image, $slideStatus);
            } else {
                Slider::addSlide($this->idAdmin, $slideName, $image, $slideStatus);
            }
        } else {
            Slider::find($request->slide_edit_id)->update(['slide_name' => $slideName, 'slide_status' => $slideStatus]);
        }

        return redirect(url('/office') . '/slider');
    }

	/**
	 * Edit current slide
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
	 */
    public function editSlide(Request $request)
    {
        if (Gate::denies('admin')) {
            return redirect('/office/orders_list');
        }

        $this->data['slideInfo'] = Slider::find($request->id);

        return view('admin.slider_edit', $this->data);
    }

	/**
	 * Delete current slide
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
    public function removeSlide(Request $request)
    {
        if (Gate::denies('admin')) {
            return redirect('/office/orders_list');
        }

        $oldSlider = Slider::find($request->id);
        $fullPath = public_path() . '/images' . '/sliders/' . $this->idAdmin . '/';
        Slider::find($request->id)->delete();

        unlink($fullPath . $oldSlider->image);
        return redirect(url('/office') . '/slider');
    }

	/**
	 * Slide resize
	 *
	 * @param      $file_input
	 * @param      $file_output
	 * @param int  $w_o
	 * @param int  $h_o
	 * @param bool $percent
	 *
	 * @return bool
	 */
    public static function resizeSlide($file_input, $file_output, $w_o = 888, $h_o = 300, $percent = false)
    {
        list($w_i, $h_i, $type) = getimagesize($file_input);
        if (!$w_i || !$h_i) {
            return false;
        }
        $types = array('', 'gif', 'jpeg', 'png');
        $ext = $types[$type];
        if ($ext) {
            $func = 'imagecreatefrom' . $ext;
            $img = $func($file_input);
        } else {
            return false;
        }
        if ($percent) {
            $w_o *= $w_i / 100;
            $h_o *= $h_i / 100;
        }
        if (!$h_o) {
            $h_o = $w_o / ($w_i / $h_i);
        }
        if (!$w_o) {
            $w_o = $h_o / ($h_i / $w_i);
        }
        $img_o = imagecreatetruecolor($w_o, $h_o);

        imagecopyresampled($img_o, $img, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i);

        if ($type == 2) {
            return imagejpeg($img_o, $file_output, 100);
        } else {
            $func = 'image' . $ext;
            return $func($img_o, $file_output);
        }
    }

}
