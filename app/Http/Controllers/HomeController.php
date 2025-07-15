<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return User::with(['role', 'role.permissions'])->find(2);
        
        // return Auth::user()->load(['role', 'role.permissions']);
        // $date_1 = config('app.app_init_date');
        $date_1 = date("Y-m-d");
        $date_2 = config('app.app_init_deadline');

        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);
        
        $date_diff = date_diff($datetime1, $datetime2);

        return view('pages.dashboard', [
            'code_verified' => config('app.code_verified'),
            'remaining_days' => $date_diff->format('%a')
        ]);
    }
}
