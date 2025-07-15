<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Currency;
use App\Company;
use App\Permission;
use App\User;

use App\AccountHead;
use App\BalanceHistory;

use Auth;
use App\Activity;

use Storage;

class CompaniesController extends Controller
{
    public function index(){
    	return view('pages.companies.home');
    }

    public function list(){
    	$companies = Company::orderBy('comp_name')->get();

        foreach ($companies as $i => $company) {
            $file_exists = Storage::disk('local')->exists($company->logo);

            if($file_exists){
                $company->logo = asset(Storage::url($company->logo));

                // return "<img src='$company->logo'/>";
            }

            $currency = Currency::find($company->currency);

            if(empty($currency->symbol)){
                $currency->symbol = $currency->code;
            }

            $company->currency = $currency->name." (".$currency->symbol.")";

            $userRoles = Permission::where('comp_id', $company->id)->get(['role_id']);
            $role_ids = [];

            foreach ($userRoles as $i => $role){
                $role_ids[$i] = $role['role_id'];
            }

            $users = User::whereIn('role_id', $role_ids)->get(['name']);

            $company->users = $users;
        }

        // return $companies;

        $currencies = Currency::all();

        foreach ($currencies as $i => $cur) {
            if(empty($cur->symbol)){
                $cur->symbol = $cur->code;
            }
        }

        // return "<pre>".$companies."</pre>";


        return view('pages.companies.list', [
          'companies' => $companies,
          'currencies' => $currencies
      ]);
    }

    public function add(Request $request){
        $company = Company::create([
            'comp_name' => $request->comp_name,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'zip_code' => $request->zip_code,
            'logo' => null,
            'brand_color_1' => $request->brand_color_1,
            'brand_color_2' => $request->brand_color_2,
            'currency' => $request->currency
        ]);

        $logo_ext = $request->logo->extension();

        $file_name = 'companies/'.$company->id.'/logo.'.$logo_ext;

        $path = Storage::putFileAs('public/companies/'.$company->id, $request->file('logo'), 'logo.'.$logo_ext);

        $company->logo = $path;
        $company->save();

        // Create Account Heads and Balance
        $asset = AccountHead::create([
            'comp_id' => $company->id,
            'parent_id' => 0,
            'name' => 'Assets',
            'desc' => 'Tangible and Intangible items that the company owns that have value (e.g. Cash, Computer Systems, Patents).',
            'increased_on' => 0,
            'ledger' => '0'
        ]);
        $asset->root_account = $asset->id;
        $asset->save();
        BalanceHistory::create([
            'acc_id' => $asset->id,
            'date' => date("Y-m-d"),
            'opening_balance' => 0,
            'closing_balance' => 0
        ]);

        $liability = AccountHead::create([
            'comp_id' => $company->id,
            'parent_id' => 0,
            'name' => 'Liabilities',
            'desc' => 'Money that the company owes to others (e.g. Mortgages, Vehicle loans).',
            'increased_on' => 1,
            'ledger' => '0'
        ]);
        $liability->root_account = $liability->id;
        $liability->save();
        BalanceHistory::create([
            'acc_id' => $liability->id,
            'date' => date("Y-m-d"),
            'opening_balance' => 0,
            'closing_balance' => 0
        ]);

        $equity = AccountHead::create([
            'comp_id' => $company->id,
            'parent_id' => 0,
            'name' => 'Equity',
            'desc' => 'Portion of the total assets that the owners or stockholders of the company fully own.',
            'increased_on' => 1,
            'ledger' => '0'
        ]);
        $equity->root_account = $equity->id;
        $equity->save();
        BalanceHistory::create([
            'acc_id' => $equity->id,
            'date' => date("Y-m-d"),
            'opening_balance' => 0,
            'closing_balance' => 0
        ]);

        $revenue = AccountHead::create([
            'comp_id' => $company->id,
            'parent_id' => 0,
            'name' => 'Income/Revenue',
            'desc' => 'Money the company earns from its sales of Products or Services, Interest and Dividends earned from marketable securities.',
            'increased_on' => 1,
            'ledger' => '0'
        ]);
        $revenue->root_account = $revenue->id;
        $revenue->save();
        BalanceHistory::create([
            'acc_id' => $revenue->id,
            'date' => date("Y-m-d"),
            'opening_balance' => 0,
            'closing_balance' => 0
        ]);

        $expense = AccountHead::create([
            'comp_id' => $company->id,
            'parent_id' => 0,
            'name' => 'Expense',
            'desc' => 'Money the company spends to produce the Goods or Services that it Sells (Ex: Office Supplies, Utilities, Advertising).',
            'increased_on' => 0,
            'ledger' => '0'
        ]);
        $expense->root_account = $expense->id;
        $expense->save();
        BalanceHistory::create([
            'acc_id' => $expense->id,
            'date' => date("Y-m-d"),
            'opening_balance' => 0,
            'closing_balance' => 0
        ]);


        // Add Activity to Log
        $user = Auth::user();
        $affected_module = 'Companies';

        $narration = $user->name." added the company <b>'".$company->comp_name."'</b>.";
        $narration .= " at <b>".date("jS-F, Y").", ".date('h:i A')."</b>.";

        Activity::create([
          'user_id' => $user->id,
          'user_name' => $user->name,
          'affected_module' => $affected_module,
          'ref_id' => $company->id,
          'action' => 'Add',
          'narration' => $narration,
          'date' => date("Y-m-d")
      ]);
    }

    public function edit(Request $request){
        $currency = Currency::find($request->id);

        $currency->name = $request->name;
        $currency->symbol = $request->symbol;
        $currency->code = $request->code;
        $currency->decimal_places = $request->decimal_places;
        $currency->symbol_placement = $request->symbol_placement;

        $currency->save();

        return $currency;
    }
}
