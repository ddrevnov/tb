<?php

namespace App\Http\Controllers\Director;

use App\Admin;
use App\Chat_massage;
use App\DirectorEmployee;
use App\Employee;
use Illuminate\Http\Request;
use LRedis;
use Illuminate\Support\Facades\Auth;

class DirectorMessagesController extends DirectorController 
{
    //вывод страницы с чатами для всех админов, их сотрудников и сотрудников директора
    public function messages(Employee $employee, DirectorEmployee $directorEmployee) 
    {
        $this->data['user_id'] = Auth::id();
        $this->data['director_employees'] = $directorEmployee->getDirectorEmployeeNewMessage();
        $this->data['admin_employees'] = $employee->getEmployeeNewMessage();

        return view('director.messages', $this->data);
    }

    //отправка сообщения в чате через redis
    public function sendMessage(Request $request)
    {
        $to = $request->userId;

        $from = Auth::id();
        $text = $request->text;
        Chat_massage::create(['massage' => $text, 'to' => $to, 'from' => $this->userId, 'status' => 1]);
        $redis = LRedis::connection();

        if(Admin::where('user_id', $from)->first()){
            $first_name = Admin::where('user_id', $from)->first()->firstname;
            $last_name = Admin::where('user_id', $from)->first()->lastname;
        }elseif (Employee::where('user_id', $from)->first()){
            $first_name = Employee::where('user_id', $from)->first()->name;
            $last_name = Employee::where('user_id', $from)->first()->last_name;
        }elseif(DirectorEmployee::where('user_id', $from)){
            $first_name = DirectorEmployee::where('user_id', $from)->first()->name;
            $last_name = DirectorEmployee::where('user_id', $from)->first()->last_name;
        }else{
            $first_name = '';
            $last_name = '';
        }

        $redisMessage = ['to' => $to, 'from' => $from, 'text' => $text, 'first_name' => $first_name, 'last_name' => $last_name];

        $redis->publish('new_message', json_encode($redisMessage, JSON_UNESCAPED_UNICODE));
        return response()->json(["userId" => $request->userId, "text" => $request->text]);
    }

    //получение последних сообщений при начале чата с пользователем. повтороное обращение подгружает еще 10 сообщений
    public function getUserChat(Request $request)
    {
        if($request->count == 1){
            Chat_massage::where(['from' => $request->userId, 'to' => $this->userId])->update(['status' => 0]);    
        }
        
        $userChat = Chat_massage::where(['to' => $request->userId, 'from' => $this->userId])
                                ->orWhere(['from' => $request->userId, 'to' => $this->userId])
                                ->orderBy('created_at', 'desc')
                                ->select('id as message_id', 'to', 'from', 'status', 'massage as text', 'created_at')
                                ->take(10 * $request->count)->get()->toArray();

        $length = Chat_massage::where(['to' => $request->userId, 'from' => $this->userId])->count();

        return response()->json(['messages' => array_reverse($userChat), 'length' => $length]);
    }

    //запрос новых сообщений для отображения уведомлений
    public function getNewMessages()
    {
        $fromIds = Chat_massage::where(['to' => $this->userId, 'status' => 1])->groupBy('from')->get()->toArray();
        
        if(!$fromIds){
            return response()->json(false);
        }
        
        $fromIds = array_pluck($fromIds, 'from');
        $fromAdminIds = Admin::lists('user_id')->toArray();

        $who[0] = Admin::whereIn('admins.user_id', $fromIds)
                        ->where('chat_massages.status', 1)
                        ->leftJoin('avatars', 'avatars.user_id', '=', 'admins.user_id')
                        ->join('chat_massages', 'chat_massages.from', '=', 'admins.user_id')
                        ->select('admins.user_id as from', 'firstname as first_name', 'lastname as last_name',
                                'avatars.path', 'chat_massages.massage as message', 'chat_massages.created_at')
                        ->orderBy('chat_massages.created_at', 'desc')->groupBy('admins.user_id')
                        ->get()->toArray();
        $who[1] = Employee::whereNotIn('employees.user_id', $fromAdminIds)
                            ->whereIn('employees.user_id', $fromIds)
                            ->where('chat_massages.status', 1)
                            ->leftJoin('avatars', 'avatars.user_id', '=', 'employees.user_id')
                            ->join('chat_massages', 'chat_massages.from', '=', 'employees.user_id')
                            ->select('employees.user_id as from', 'name as first_name', 'last_name', 'avatars.path',
                                    'chat_massages.massage as message', 'chat_massages.created_at')
                            ->orderBy('chat_massages.created_at', 'desc')->groupBy('employees.user_id')
                            ->get()->toArray();
        $who[2] = DirectorEmployee::whereIn('director_employees.user_id', $fromIds)
                                    ->where('chat_massages.status', 1)
                                    ->leftJoin('avatars', 'avatars.user_id', '=', 'director_employees.user_id')
                                    ->join('chat_massages', 'chat_massages.from', '=', 'director_employees.user_id')
                                    ->select('director_employees.user_id as from', 'name as first_name', 'last_name',
                                            'avatars.path', 'chat_massages.massage as message', 'chat_massages.created_at')
                                    ->orderBy('chat_massages.created_at', 'desc')->groupBy('director_employees.user_id')
                                    ->get()->toArray();
        //приведение уведомлений в нужную фронту форму
        $i = 0;
        foreach($who as $w){
            foreach ($w as $n){
                $result[$i] = $n;
                $i++;
            }
        }
        return response()->json(isset($result) ? $result : false);
    }
}
