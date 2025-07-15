<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use Auth;
use App\Currency;
use App\Company;
use App\Activity;

class CurrenciesController extends Controller
{
  public function index(){
    return view('pages.currencies.home');
  }

  public function list(){
    $currencies = Currency::with('companies')->orderBy('name')->get();

    foreach($currencies as $currency){
      if(sizeof($currency->companies) == 0){
        $currency->can_delete = true;
      }
      else{
        $currency->can_delete = false;
      }
    }

    return view('pages.currencies.list', [
      'currencies' => $currencies
    ]);
  }

  public function add(Request $request){
    $attribute_names = [
      'name' => 'Name',
      'symbol' => 'Symbol',
      'code' => 'Currency Code',
      'decimal_places' => 'Decimal Places',
      'symbol_placement' => 'Symbol Placement',
    ];

    $validation_rules = [
      'name' => 'required|unique:currencies,name|max:255',
      'symbol' => 'max:1',
      'code' => 'required|unique:currencies,code|max:3',
      'decimal_places' => 'required|numeric',
      'symbol_placement' => 'required',
    ];

    $messages = [
      'required' => 'The <b>:attribute</b> is a required field.',
      'unique' => 'A Currency with the given <b>:attribute</b> already exists.',
    ];

    $validator = Validator::make($request->all(), $validation_rules, $messages);
    $validator->setAttributeNames($attribute_names); 
    
    if ($validator->fails()){
      return $validator->messages();
    }
    else{
      $currency = Currency::create([
        'name' => $request->name,
        'symbol' => $request->symbol,
        'code' => $request->code,
        'decimal_places' => $request->decimal_places,
        'symbol_placement' => $request->symbol_placement,
      ]);

      // Add to Activity
      $user = Auth::user();

      $affected_module = 'Currencies';
      $narration = $user->name." added <b>'".$currency->name."'</b>.";
      $narration .= " at <b>".date("jS-F, Y").", ".date('h:i A')."</b>.";

      Activity::create([
        'user_id' => $user->id,
        'user_name' => $user->name,
        'affected_module' => $affected_module,
        'ref_id' => $currency->id,
        'action' => 'Add',
        'narration' => $narration,
        'date' => date("Y-m-d")
      ]);
      return "true";
    }
  }

  public function edit(Request $request){
    $currency = Currency::find($request->id);

    $currency->name = $request->name;
    $currency->symbol = $request->symbol;
    $currency->code = $request->code;
    $currency->decimal_places = $request->decimal_places;
    $currency->symbol_placement = $request->symbol_placement;

    $currency->save();

    // Add to Activity
    $user = Auth::user();

    $affected_module = 'Currencies';
    $narration = $user->name." edited <b>'".$currency->name."'</b>.";
    $narration .= " at <b>".date("jS-F, Y").", ".date('h:i A')."</b>.";

    Activity::create([
      'user_id' => $user->id,
      'user_name' => $user->name,
      'affected_module' => $affected_module,
      'ref_id' => $currency->id,
      'action' => 'Edit',
      'narration' => $narration,
      'date' => date("Y-m-d")
    ]);

    return $currency;
  }

  public function delete(Request $request){
    $currency = Currency::find($request->id);

    // Add to Activity
    $user = Auth::user();

    $affected_module = 'Currencies';
    $narration = $user->name." deleted <b>'".$currency->name."'</b>.";
    $narration .= " at <b>".date("jS-F, Y").", ".date('h:i A')."</b>.";

    Activity::create([
      'user_id' => $user->id,
      'user_name' => $user->name,
      'affected_module' => $affected_module,
      'ref_id' => $currency->id,
      'action' => 'Delete',
      'narration' => $narration,
      'date' => date("Y-m-d")
    ]);

    $currency->delete();
  }
}
