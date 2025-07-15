<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Activity;
use App\User;

class ActivityLogController extends Controller
{
    public function index(){
    	$temp = Activity::orderBy('created_at', 'asc')->get()->first();

        $from_date = date("Y-m-01");
        if(!empty($temp)){
            $temp_arr = explode(' ', $temp->created_at);
            $from_date = $temp_arr[0];    
        }

    	$temp = Activity::orderBy('created_at', 'desc')->get()->first();

        $to_date = date("Y-m-t");
        if(!empty($temp)){
            $temp_arr = explode(' ', $temp->created_at);
            $to_date = $temp_arr[0];    
        }

    	$users = User::get(['id', 'name']);

    	return view('pages.activity_log.home', [
    		'from_date' => $from_date,
    		'to_date' => $to_date,
    		'users' => $users
    	]);
    }

    public function list(Request $request){
        // return $request->all();
        $user_id = $request->get('user_id');
        $action = $request->get('action');
        $from_date = $request->get('from_date');
        $to_date = $request->get('to_date');

        $activities = new Activity;

        if($user_id == 'All' && $action == 'All'){
            $activities = Activity::where([
                ['date', ">=", $from_date],
                ['date', "<=", $to_date],
            ])->orderBy('created_at', 'desc')->get();
        }
        elseif($user_id != 'All' && $action != 'All'){
            $activities = Activity::where([
                ['user_id', $user_id],
                ['action', $action],
                ['date', ">=", $from_date],
                ['date', "<=", $to_date],
            ])->orderBy('created_at', 'desc')->get();
        }
        else if($user_id != 'All'){
            $activities = Activity::where([
                ['user_id', $user_id],
                ['date', ">=", $from_date],
                ['date', "<=", $to_date],
            ])->orderBy('created_at', 'desc')->get();
        }
        else if($action != 'All'){
            $activities = Activity::where([
                ['action', $action],
                ['date', ">=", $from_date],
                ['date', "<=", $to_date],
            ])->orderBy('created_at', 'desc')->get();
        }
        else{
            $activities = Activity::orderBy('created_at', 'desc')->get();
        }

        return view("pages.activity_log.list", [
            'activities' => $activities
        ]);
    }
}
