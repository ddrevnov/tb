<?php
//
//namespace App\Http\Controllers;
//
//use App\AdminNotice;
//use App\AdminsClients;
//use App\Avatar;
//use App\Employee;
//use App\User;
//use App\WorkTime;
//use Illuminate\Http\Request;
//use App\Http\Requests;
//use App\Client;
//use App\Admin;
//use App\Firm;
//use App\Image;
//use App\Services;
//use App\ServicesCategory;
//use App\Slider;
//use App\Comment;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Mail;
//use Symfony\Component\HttpFoundation\Session\Session;
//use Validator;
//use Filter;
//use App\DB;
//use App\EmployeeService;
//use App\Calendar;
//use Carbon\Carbon;
//
//class UserController extends Controller
//{
//
//    public $firmLink;
//    public $adminId;
//    public $data = array();
//
//    public function __construct(Request $request)
//    {
//        //dd($request->session()->all());
//        /* get subdomain for client site response */
//        $this->firmLink = explode('.', $_SERVER['HTTP_HOST']);
//        $this->firmLink = array_shift($this->firmLink);
//        $this->adminId = Admin::getAdminIdFromFirmLink($this->firmLink);
//        $this->data['firm_logo'] = Image::where('admin_id', $this->adminId)->first();
//        $this->data['sliders'] = Slider::getSlidersList($this->adminId);
//        $this->data['slidersFolder'] = 'sliders/' . $this->adminId;
//        $this->data['locale'] = $request->session()->get('locale');
//    }
//
//    public function index()
//    {
//        return view('users.login', $this->data);
//    }
//
//    public function about()
//    {
//        $this->data['about_us'] = Firm::getAboutUs($this->firmLink);
//
//        return view('users.about', $this->data);
//    }
//
//    public function booking($domain)
//    {
//        $this->data['categoryList'] = ServicesCategory::getActiveServicesCategoryList($this->adminId);
//        $this->data['servicesList'] = Services::getActiveServicesList($this->adminId);
//        $this->data['employees'] = Employee::getEmployeesActive($this->adminId);
//        $this->data['firm_details'] = Firm::where('firmlink', $domain)->first();
//
//        return view('users.booking', $this->data);
//    }
//
//    public function getEmployees(Request $request)
//    {
//        $result = EmployeeService::getEmployees($request->service_id);
//
//        return json_encode($result);
//    }
//
//    public function getWorkTimes(Request $request, $domain)
//    {
//        $result = WorkTime::where('firmlink', $domain)->select('from', 'to', 'index_day')->get();
//        return json_encode($result);
//    }
//
//    public function checkEmployee(Request $request, $domain, Calendar $calendar)
//    {
//
//        if ($request->start_time == '') {
//            return 0;
//        }
//        $duration = $request->duration ? $request->duration : 0;
//        $start_time = \DateTime::createFromFormat('H:i', $request->start_time);
//        $interval = "PT" . $duration . "M";
//        $end_time = \DateTime::createFromFormat('H:i', $request->start_time)->add(new \DateInterval($interval));
//
//        $date = array($request->date);
//        $empl_id = $request->id;
//
//        //check worktimes firm
//        $week_index_day = \DateTime::createFromFormat('d/m/Y', $request->date)->modify('-1 day')->format('w');
//        $work_time = WorkTime::where(['firmlink'=> $domain, 'index_day' => $week_index_day])->first();
//        $work_time_from = \DateTime::createFromFormat('H:i:s', $work_time->from)->format('H:i');
//        $work_time_to = \DateTime::createFromFormat('H:i:s', $work_time->to)->format('H:i');
//
//        if($start_time->format('H:i') < $work_time_from || $end_time->format('H:i') > $work_time_to){
//            return response()->json(false);
//        }
//
//        $calendarInfo = $calendar->checkTime($domain, $date, $empl_id);
//
//        if ($calendarInfo->isEmpty()) {
//            return response()->json(['end_time' => $end_time->format('H:i'), 'check' => true]);
//        }
//
//        foreach ($calendarInfo as $info) {
//            $from = \DateTime::createFromFormat('H:i', $info->time_from);
//            $to = \DateTime::createFromFormat('H:i', $info->time_to);
//
//            if ($start_time >= $from && $start_time <= $to) {
//                return response()->json(['end_time' => $end_time->format('H:i'), 'check' => false]);
//            } else {
//                if ($end_time >= $from && $end_time <= $to) {
//                    return response()->json(['end_time' => $end_time->format('H:i'), 'check' => false]);
//                }
//            }
//        }
//
//        return response()->json(['end_time' => $end_time->format('H:i'), 'check' => true]);
//    }
//
//    public function gustebook($domain)
//    {
//        $idclient = Client::where('user_id', '=', Auth::id())->first();
//
//        $idfirm = Firm::where('firmlink', '=', $domain)->first()->id;
//        $this->data['comments'] = Comment::where('id_firm',$idfirm)->join('clients', 'comments.id_clients', '=', 'clients.id')
//            ->select('comments.id', 'comments.heading', 'comments.text', 'comments.star', 'comments.id_firm', 'comments.name_firm', 'comments.created_at',
//                'clients.first_name', 'comments.id_clients')->orderBy('comments.created_at', 'desk')->paginate(10);
//
//            $this->data['client_id'] = isset($idclient) ? $idclient->id : '';
//        return view('users.gustebook', $this->data);
//        }
//
//    public function editgustebook(Request $request, $domain)
//    {
//
//        $time = $request->input('time');
//        $heading = $request->input('heading');
//        $text = $request->input('text');
//        $star = $request->input('star');
//        $idclient = Client::where('user_id', '=', Auth::user()->id)->first();
//        $idfirm = Firm::where('firmlink', '=', $domain)->first();
//        $client = Client::where('firmlink', '=', $domain)->first();
//
//        if (!empty($client)) {
//            $comments = Comment::create(['time' => $time, 'heading' => $heading, 'text' => $text, 'star' => $star,
//                'id_clients' => $idclient->id, 'id_firm' => $idfirm->id, 'name_firm' => $client->firmlink]);
//
//        }
//        return redirect('/client/gustebook');
//    }
//
//    public function deletegustebook(Request $request, $domain, $id)
//    {
//        $comments = Comment::where('id', $id)->delete();
//
//        return response()->json(["status" => true]);
//
//    }
//
//    public function editcommentsgustebook(Request $request, $domain, $id)
//    {
//        $heading = $request->input('heading');
//        $text = $request->input('text');
//        $stars = $request->input('stars');
//        $comments = Comment::where('id', $id)->update(['text' => $text, 'heading' => $heading, 'star' => $stars]);
//
//        return response()->json(["status" => true]);
//
//    }
//
//
//    public function kontact()
//    {
//        $this->data['firm_details'] = Firm::getFirmDetails($this->firmLink);
//        $this->data['admin_details'] = Admin::getActiveAdminInfo($this->adminId);
//        //dd($this->data['admin_details']);
//        $this->data['firmShedule'] = WorkTime::getFirmShedule($this->firmLink);
//        $this->data['days'] = ['Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag', 'Sonntag'];
//
//        return view('users.kontact', $this->data);
//    }
//
//    public function newsletter()
//    {
//        $client_id = Client::where('user_id', Auth::id())->first()->id;
//        $this->data['subscribe'] = AdminsClients::getClientSubscribes($client_id);
//
//        return view('users.newsletter', $this->data);
//    }
//
//    public function newsletterEdit(Request $request)
//    {
//        $client_id = Client::where('user_id', Auth::id())->first()->id;
//        AdminsClients::where('client_id', $client_id)->update(['email_send' => 0]);
//        if ($request->subscribe){
//                AdminsClients::whereIn('admin_id', $request->subscribe)->update(['email_send' => 1]);
//        }
//
//        return redirect()->back();
//    }
//
//    public function settings(Request $request)
//    {
//        $user = $request->user();
//        $client = Client::where('user_id', $user->id)->first();
//        $data = $this->data;
//        $data['client'] = $client;
//        $data['avatar'] = Avatar::where('user_id', $user->id)->first();
////        $data['email_send'] = AdminsClients::where(['admin_id' => $this->adminId, 'client_id' => $client->id])
////                                            ->first()->email_send;
//        return view('users.settings', $data);
//    }
//
//    public function registration()
//    {
//        return view('users.registration', $this->data);
//    }
//
//    public function checkEmail(Request $request)
//    {
//        $email = $request['email'];
//        $check = true;
//
//        if (User::getEmail($email)) {
//            $check = false;
//        }
//
//        return json_encode($check);
//    }
//
//    public function store(Request $request, $domain)
//    {
//
//        if (User::where('email', $request->input('email'))->first()) {
//            return redirect(url('/') . '/client/registration');
//        }
//        $data = $request->all();
//        $rules = [
//            'email' => 'required|email',
//            'first_name' => 'required',
//            'last_name' => 'required'
//        ];
//
//        $validator = Validator::make($data, $rules);
//
//        if ($validator->fails()) {
//              return response()->json(["status" => false]);
//        }
//        $password = "";
//        $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
//        $max = count($characters) - 1;
//        for ($i = 0; $i < 8; $i++) {
//            $rand = mt_rand(0, $max);
//            $password .= $characters[$rand];
//        }
//
//        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
//        $user = User::create(['name' => $data['first_name'], 'email' => $data['email'], 'password' => $passwordHash, 'status' => 'user']);
//        $data['user_id'] = $user->id;
//        $data['firmlink'] = $domain;
//        $data['birthday'] = (new \DateTime($data['birthday']))->format('Y-m-d');
//        $client = Client::create($data);
//
//        $adminId = Admin::where('firmlink', $domain)->first()->id;
//        AdminsClients::create(['client_id' => $client->id, 'admin_id' => $adminId]);
//
//        Auth::attempt(['email' => $data['email'], 'password' => $password]);
//        Mail::send('emails.welcome_client',
//            ['password' => $password,
//                'firstname' => $data['first_name'],
//                'lastname' => $data['last_name'],
//                'email' => $data['email'],
//                'gender' => $data['gender'],
//                'firmlink' => 'http://' . $_SERVER['HTTP_HOST'],
//            ],
//            function ($message) use ($user, $client) {
//                $message->to($user->email, $client->first_name . " " . $client->last_name)->subject('Registration succesfull');
//            });
//
//        return response()->json(["status" => true]);
//
//    }
//
//    public function check(Request $request)
//    {
//
//        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
//            return redirect(url('/') . '/client/settings');
//        } else {
//            return redirect(url('/') . '/client');
//        }
//    }
//
//    public function logout(Request $request)
//    {
//        Auth::logout();
//        return redirect(url('/') . '/client');
//    }
//
//    public function changeAvatar(Request $request)
//    {
//
//        Avatar::storeAvatar($request->user()->id, $request);
//
//        return redirect(url('/') . '/client/settings');
//    }
//
//    public function update(Request $request)
//    {
//        $userId = $request->user()->id;
//        $client = Client::where('user_id', $userId)->first();
//        $data = $request->all();
//        if (isset($data['birthday'])) {
//            $data['birthday'] = (new \DateTime($data['birthday']))->format('Y-m-d');
//        }
//        $client->update($data);
//
//        return redirect(url('/') . '/client/settings');
//    }
//
//    public function updatePassword(Request $request)
//    {
//        $user = $request->user();
//        $user->password = password_hash($request->input('password'), PASSWORD_BCRYPT);
//        $user->save();
//        return redirect(url('/') . '/client/settings');
//    }
//
//    public function getAdmin(Request $request, Services $services)
//    {
//        if ($request->ajax()) {
//            $admins = $services->getServiceAdmin($request->data);
//
//            return response()->json($admins);
//        }
//        return false;
//    }
//
//    public function newOrder(Request $request, $domain)
//    {
//
//        $client = Client::where('user_id', Auth::id())->first();
//        $adminId = Admin::where('firmlink', $domain)->first()->id;
//
//        if(!AdminsClients::where(['client_id' => $client->id, 'admin_id' => $adminId])->first()){
//            AdminsClients::create(['client_id' => $client->id, 'admin_id' => $adminId]);
//        }
//
//        $email = $client->email;
//
//        $orderByClient = [
//            'domain' => $domain,
//            'color' => '#0F0F0F',
//            'description' => 'ORDER FROM SITE',
//            'time_from' => $request->time_start,
//            'time_to' => $request->time_end,
//            'date' => $request->date,
//            'employee_id' => $request->employee_id,
//            'service_id' => $request->service_id,
//            'client_id' => $client->id,
//            'status' => 'active',
//            'site' => 1
//        ];
//
//        $cart = Calendar::create($orderByClient);
//        $data = Calendar::getInfoForConfirmEmail($cart->id, $domain);
//        $data = $data->toArray();
//        $data['path'] = public_path() . $data['path'];
//        $data['locale'] = $locale = User::find($client->user_id)->locale;
//        $subject = trans('emails.create', [], $locale);
//
//        AdminNotice::create(['notice_type' => 'new_order', 'admin_id' => $this->adminId]);
//
//        Mail::send('emails.confirm_order',
//            $data,
//            function ($message)
//            use ($email, $domain, $subject) {
//                $message->from($domain . '@timebox24.com', $domain);
//                $message->to($email)->subject($subject);
//            });
//
//        return '1';
//    }
//    public function forgotpas(Request $request)
//    {
//
//        $password = "";
//        $email = $request->input('forgotpass');
//
//        if($user = User::where('email', "=", $email)->first()) {
//            $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
//            $max = count($characters) - 1;
//            for ($i = 0; $i < 8; $i++) {
//                $rand = mt_rand(0, $max);
//                $password .= $characters[$rand];
//                $passwordHash = password_hash($password, PASSWORD_BCRYPT);
//                $user->update(['password' => $passwordHash]);
//            }
//            Mail::send('emails.forgotpass', ['password' => $password], function ($message) use ($user) {
//                $message->from('director@timebox.com');
//                $message->to($user->email)->subject('New Password');
//
//            });
//            return response()->json(['1']);
//        }else{
//            return response()->json(['0']);
//        }
//    }
//
//    public function setLocale(Request $request)
//    {
//        //dd($request->session()->all());
//        if (Auth::check()){
//            $user = User::find(Auth::id());
//            $user->locale = $request->loc;
//            $user->save();
//            return redirect()->back();
//        }else{
//            \Session::put('locale', $request->loc);
//            \Session::save();
//        }
//        return redirect()->back();
//    }
//}
