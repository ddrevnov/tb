<?php

namespace App\Http\Controllers\Director;

use App\City;
use App\Client;
use App\Country;
use App\Employee;
use App\Firm;
use App\Mail as DirectorMail;
use App\Order;
use App\State;
use Illuminate\Http\Request;
use App\Admin;
use Illuminate\Support\Facades\Gate;
use App\Chat_massage;
use Illuminate\Support\Facades\Auth;
use App\User;

class DirectorController extends \App\Http\Controllers\Controller
{
    public $data = array();
    public $userId;

    public function __construct()
    {

        $this->userId = Auth::id();
        $this->middleware('SessionLogout');
        $this->middleware('statusDirector');
        $chatCount = Chat_massage::where(['to' => $this->userId, 'status' => 1])->groupBy('from')->distinct('from')->get()->count();

        $this->data = ['chatCount' => $chatCount];
    }

    //вывод дашборда директора с последними 5-ю сообщениями в чате
    public function index()
    {
        if (Gate::denies('director')) {
            return redirect()->route('admins');
        }

        $this->data['last_chat_messages'] = Chat_massage::getDashboardLastMessages($this->userId);
        $statistic = Firm::getFirms();
        $result = array();
        foreach ($statistic as $place => $value){
            foreach($value as $key2 => $value2){
                if(isset($result[$key2][$value2] )){
                    $result[$key2][$value2]++;
                }else{
                    $result[$key2][$value2] = 1;
                }
            }
        }
        $this->data['statistic'] = $result;
        $this->data['all_firms'] = count($statistic);

        return view('director.dashboard', $this->data);
    }

    //живой поиск по админа, сотрудникам и письмам директора
    public function search(Request $request)
    {
        $q = $request->q;
        $result['admins'] = Admin::where('admins.status', '!=', 'new')->where(function ($query) use ($q) {
            $query->where('firstname', 'like', "%$q%")
                ->orWhere('lastname', 'LIKE', "%$q%")
                ->orWhere('email', 'LIKE', "%$q%")
                ->orWhere('telnumber', 'LIKE', "%$q%");
        })->select('admins.id', 'admins.firstname as admin_first_name', 'admins.lastname as admin_last_name',
            'admins.email as admin_email', 'admins.telnumber as admin_telnumber', 'admins.status as admin_status')->get()->toArray();

        $result['admins_new'] = Admin::where('admins.status', 'new')->where(function ($query) use ($q) {
            $query->where('firstname', 'like', "%$q%")
                ->orWhere('lastname', 'LIKE', "%$q%")
                ->orWhere('email', 'LIKE', "%$q%")
                ->orWhere('telnumber', 'LIKE', "%$q%");
        })->select('admins.id', 'admins.firstname as admin_first_name', 'admins.lastname as admin_last_name',
            'admins.email as admin_email', 'admins.telnumber as admin_telnumber', 'admins.status as admin_status')->get()->toArray();

        $result['employees'] = Employee::where(function ($query) use ($q) {
            $query->where('name', 'like', "%$q%")
                ->orWhere('last_name', 'LIKE', "%$q%")
                ->orWhere('email', 'LIKE', "%$q%")
                ->orWhere('phone', 'LIKE', "%$q%");
        })->select('employees.id', 'employees.name as employee_first_name', 'employees.last_name as employee_last_name',
            'employees.email as employee_email', 'employees.phone as employee_telnumber')->get()->toArray();

        $result['letters'] = DirectorMail::where(function ($query) use ($q) {
            $query->where('subject', 'like', "%$q%");
        })->select('mails.id', 'mails.subject')->get()->toArray();

        $result['clients'] = Client::where(function ($query) use ($q) {
            $query->where('first_name', 'like', "%$q%")
                    ->orWhere('last_name', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%")
                    ->orWhere('mobile', 'like', "%$q");
        })->select('clients.id', 'clients.first_name as client_first_name', 'clients.last_name as client_last_name',
                                'clients.email as client_email', 'clients.mobile as client_mobile')->get()->toArray();

        //приведение результатов поиска в требуемый для фронта вид
        $search_res = array();
        foreach ($result as $key => $res) {
            $search_res[$key] = array();
            foreach ($res as $r) {
                $r = array_filter($r, function ($item) use ($q) {
                    if (is_int($item)) {
                        return true;
                    } else {
                        return preg_match("/" . $q . "/i", $item);
                    }
                });
                $search_res[$key][] = $r;
            }
        }

        $qb = sscanf($q, 'T%05u')[0];
        $bills = Order::find($qb);
        if($bills){
            $search_res['bills'] = [['id' => $bills->id, 'bill_number' => sprintf('T%05u', $bills->id)]];
        }

        return response()->json($search_res);
    }
    
    //получение всех стран, городов и штатов при редактировании данных админов
    public function getLocation(Request $request)
    {
        if(!$request->all()){
            $countries = Country::select('id as country_id', 'name')->get();
            return response()->json($countries);
        }elseif ($request->country_id){
            $states = State::where('country_id', $request->country_id)->select('id as state_id', 'name')->get();
            return response()->json($states);
        }elseif ($request->state_id){
            $cities = City::where('state_id', $request->state_id)->select('id as city_id', 'name')->get();
            return response()->json($cities);
        }
        return response()->json(false);
    }

    //проверка занят ли email при создании нового админа директором
    public function checkEmail(Request $request)
    {
        if (User::where('email', $request->email)->first()) {
            return response()->json(false);
        }
        return response()->json(true);
    }
}
