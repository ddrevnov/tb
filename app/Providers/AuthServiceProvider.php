<?php

namespace App\Providers;

use App\DirectorEmployee;
use App\Employee;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('admin', function ($user) {
            if($user->status == 'admin'){
                return true;
            }
            if($user->status == 'admin_employee'){
                $employee = Employee::where('email',$user->email)->first();
                if ($employee){
                    if ($employee->group == 'admin'){
                        return true;
                    }
                }
            }
            return false;
        });

        $gate->define('admin_employee', function($user){
            if($user->status == 'admin_employee'){
                return true;
            }
        });

        $gate->define('director', function ($user) {
            if($user->status == 'director'){
                return true;
            }
            if($user->status == 'director_employee'){
                $employee = DirectorEmployee::where('email',$user->email)->first();
                if ($employee){
                    if ($employee->group == 'admin'){
                        return true;
                    }
                }
            }
            return false;
        });
    }
}
