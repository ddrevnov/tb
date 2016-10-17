<?php

namespace App\Http\Controllers\Director;

use App\Admin;
use App\Calendar;
use App\Client;
use Illuminate\Http\Request;

class DirectorDashboardController extends DirectorController
{
    //получение данных для дашборда с привязкой к запрашиваемому периоду. если запрашивают весь период
    //возвращаются данные с момента регистрации самого первого админа
    public function getDashboard(Request $request)
    {
        if (!$request->all()) {
            $to = (new \DateTime())->format('Y-m-d');
            $from = Admin::first()->created_at->format('Y-m-d');
            $dashboard['first_data'] = $from;
        } else {
            $from = (new \DateTime($request->from))->format('Y-m-d');
            $to = (new \DateTime($request->to))->format('Y-m-d');
        }
        $dashboard['last_five_admins'] = Admin::getAdmins(5);
        $dashboard['last_five_clients'] = Client::getClients(5);

        $i = 0;
        while ($from <= $to) {
            $dashboard['subdomain_orders'][$i] = Calendar::where('site', 1)->whereDate('created_at', '=', $from)->count();
            $dashboard['calendar_orders'][$i] = Calendar::where('site', 0)->whereDate('created_at', '=', $from)->count();
            $dashboard['deleted_orders'][$i] = Calendar::whereNotNull('date_deleted')->whereDate('created_at', '=', $from)->count();
            $dashboard['clients_count'][$i] = Client::whereDate('created_at', '=', $from)->count();
            $dashboard['admins_count'][$i] = Admin::whereDate('created_at', '=', $from)->count();
            
            $i++;
            $from = date('Y-m-d', strtotime($from . '+1 day'));
        }

        return response()->json($dashboard);
    }
}
