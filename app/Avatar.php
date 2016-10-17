<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use App\Store;

/**
 * App\Avatar
 *
 * @mixin \Eloquent
 * @property integer        $id
 * @property integer        $user_id
 * @property string         $path
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Avatar whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Avatar whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Avatar wherePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Avatar whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Avatar whereUpdatedAt($value)
 */
class Avatar extends Model
{
	protected $table = 'avatars';
	protected $fillable = ['user_id', 'path'];

	public static function getAvatar($userId)
	{
		return self::where('user_id', $userId)->first();
	}

	public static function addAvatar($userId, $path)
	{
		self::where('user_id', $userId)->insert([
			'user_id' => $userId, 'path' => $path,
		]);
	}

	public static function updateAvatar($userId, $path)
	{
		self::where('user_id', $userId)->update(['path' => $path]);
	}

	public static function storeAvatar($userId, $request)
	{

		if ($request->hasFile('avatar')) {
			$avatar = $request->file('avatar');

			$path = '/avatars/images/';
			$fileName = str_random(8) . $avatar->getClientOriginalName();
			$fullPath = public_path() . $path;

			if (self::where('user_id', $userId)->first()) {
				$oldAvatar = self::where('user_id', $userId)->first()->path;
				unlink(public_path() . $oldAvatar);

				$avatar->move($fullPath, $fileName);
				self::updateAvatar($userId, $path . $fileName);
			} else {
				self::addAvatar($userId, $path . $fileName);
				//self::updateAvatar($userId, $path . $fileName);
				$avatar->move($fullPath, $fileName);
			}

			return $path . $fileName;
		}

		return false;
	}

	public static function cropAvatar($path)
	{
		self::resize($path, $path, null, 587);
		list($w_i, $h_i, $type) = getimagesize($path);
		if ($w_i > 386) {
			$del = ($w_i - 376) / 2;
			self::crop($path, $path, array($del, 0, -$del, -1));
		}
	}

	public static function resize($file_input, $file_output, $w_o, $h_o, $percent = false)
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
		if (!$h_o)
			$h_o = $w_o / ($w_i / $h_i);
		if (!$w_o)
			$w_o = $h_o / ($h_i / $w_i);
		$img_o = imagecreatetruecolor($w_o, $h_o);
		imagecopyresampled($img_o, $img, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i);
		//$img_o = self::roundImg($img_o);
		if ($type == 2) {
			return imagejpeg($img_o, $file_output, 100);
		} else {
			$func = 'image' . $ext;

			return $func($img_o, $file_output);
		}
	}

	public static function crop($file_input, $file_output, $crop = 'square', $percent = false)
	{
		list($w_i, $h_i, $type) = getimagesize($file_input);
		if (!$w_i || !$h_i) {
			echo '?????????? ???????? ????? ? ?????? ???????????';

			return;
		}
		$types = array('', 'gif', 'jpeg', 'png');
		$ext = $types[$type];
		if ($ext) {
			$func = 'imagecreatefrom' . $ext;
			$img = $func($file_input);
		} else {
			echo '???????????? ?????? ?????';

			return;
		}
		if ($crop == 'square') {
			$min = $w_i;
			if ($w_i > $h_i)
				$min = $h_i;
			$w_o = $h_o = $min;
		} else {
			list($x_o, $y_o, $w_o, $h_o) = $crop;
			if ($percent) {
				$w_o *= $w_i / 100;
				$h_o *= $h_i / 100;
				$x_o *= $w_i / 100;
				$y_o *= $h_i / 100;
			}
			if ($w_o < 0)
				$w_o += $w_i;
			$w_o -= $x_o;
			if ($h_o < 0)
				$h_o += $h_i;
			$h_o -= $y_o;
		}
		$img_o = imagecreatetruecolor($w_o, $h_o);
		imagecopy($img_o, $img, 0, 0, $x_o, $y_o, $w_o, $h_o);
		if ($type == 2) {
			return imagejpeg($img_o, $file_output, 100);
		} else {
			$func = 'image' . $ext;

			return $func($img_o, $file_output);
		}

	}
}
