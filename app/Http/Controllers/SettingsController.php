<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Currency;

class SettingsController extends Controller
{
    public function index(){

    	$currencies = Currency::all();

        foreach ($currencies as $i => $currency) {
            if(empty($currency->symbol)){
                $currency->symbol = $currency->code;
            }
        }

        // $date_1 = config('app.app_init_date');
        $date_1 = date("Y-m-d");
        $date_2 = config('app.app_init_deadline');

        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);
        
        $date_diff = date_diff($datetime1, $datetime2);

    	// return config('app.default_currency');
    	
    	return view('pages.settings.home', [
    		'code' => config('app.code'),
            'code_verified' => config('app.code_verified'),
    		'timezones' => timezone_identifiers_list(),
    		'timezone' => config('app.timezone'),
    		'timezone_selected_by_user' => config('app.timezone_selected_by_user'),
    		'currencies' => $currencies,
    		'default_currency' => config('app.default_currency'),
            'remaining_days' => $date_diff->format('%a')
    	]);
    }

    public function update(Request $request){

    }
}
