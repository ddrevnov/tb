<?php

namespace App\Http\Controllers\Director;

use App\Avatar;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Gate;
use App\DirectorEmployee;
use App\User;

class DirectorProfilController extends DirectorController
{
    //вывод профиля директора или его сотрудника
    public function profil()
    {
        $this->data['personal_info'] = DirectorEmployee::where('user_id', $this->userId)->first();
        $this->data['avatar'] = Avatar::where('user_id', $this->userId)->first();

        return view('director.profil', $this->data);
    }

    //ajax получение персональных данных для редактирования
    public function getPersonalInfo(Request $request)
    {
        if($request->ajax()){
            $personalInfo = DirectorEmployee::where('user_id', $this->userId)->first();
            return response()->json($personalInfo);
        }
        return response()->json(false);
    }

    //редактирование своих персональных данных директором или его сотрудником
    public function setPersonalInfo(Requests\UpdatePersonalInfo $request)
    {
        DirectorEmployee::where('user_id', $this->userId)->first()->update($request->all());
        return response()->json(true);
    }

    //редактирование аватара директора или его сотрудника
    public function storeAvatar(Requests\StoreAvatar $request)
    {
        $avatar = Avatar::storeAvatar($this->userId, $request);
        return $avatar->path;
    }

    //изменение пароля директора или его сотрудника
    public function setPassword(Requests\UpdatePassword $request)
    {
        $oldPass = $request['old_password'];
        $newPass = $request['new_password-1'];

        if(User::changePassword($oldPass, $newPass, $this->userId)){
            return response()->json(true);
        }else{
            return response()->json(false);
        }
    }

    //редактирование email директора или его сотрудника
    public function setEmail(Requests\UpdateEmail $request)
    {
        $changeEmail = User::where('email', $request->email)->first();
        if($changeEmail){
            return response()->json(false);
        }else{
            User::find($this->userId)->update(['email' => $request->email]);
            DirectorEmployee::where('user_id', $this->userId)->update(['email' => $request->email]);

            return response()->json(true);
        }
    }

    public function settings1() {
        return view('director.settings1', $this->data);
    }

    public function settings2() {
        if (Gate::denies('director')) {
            return redirect('backend/admins');
        }
        return view('director.settings2', $this->data);
    }

    public function settings3() {
        if (Gate::denies('director')) {
            return redirect('backend/admins');
        }
        return view('director.settings3', $this->data);
    }

    public function settings4() {
        return view('director.settings4', $this->data);
    }

}
