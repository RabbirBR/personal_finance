<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Permission;
use App\Currency;
use App\Company;
use App\AccountHead;
use App\BalanceHistory;

use App\Activity;


class ChartOfAccountsController extends Controller
{
    public function index(){
        $companies = [];

        if(Auth::user()->role['admin']){
            $companies = Company::get(['id', 'comp_name']);
        }
        else{
            $user = Auth::user()->load(['role','role.permissions']);
            foreach($user->role->permissions as $permission){
                if($permission->browse_account_heads){
                    $comp_id = $permission->comp_id;
                    $company = Company::where('id', $comp_id)->get(['id', 'comp_name'])->first();
                    array_push($companies, $company);
                }
                
            }
        }

        return view('pages.chart_of_accounts.home', [
            'companies' => $companies
        ]);
    }

    public function list(Request $request, $comp_id){
        if($comp_id == 0){
            return view('pages.chart_of_accounts.list');
        }

        $role = Auth::user()->role;

        $permission = Permission::where('role_id', $role->id)->where('comp_id', $comp_id)->get()->first();

        if($role->admin){
            $permission = new Permission;
            $permission->browse_account_heads = 1;
            $permission->add_account_head = 1;
            $permission->delete_account_head = 1;
        }

        if($permission->browse_account_heads){
            $company = Company::where('id', $comp_id)->get()->first();

            $account_heads = AccountHead::where('parent_id', 0)->where('comp_id', $comp_id)->get(['id', 'comp_id', 'parent_id', 'name', 'desc', 'increased_on', 'ledger', 'root_account']);
            foreach($account_heads as $head){
                $balance = $head->balance_history->last();
                $head->last_update_date = $balance->date;
                $head->opening_balance = $balance->opening_balance;
                $head->closing_balance = $balance->closing_balance;
                $head->children = $this->getChildAccounts($head, $comp_id);
            }

            $currency = Currency::where('id', $company->currency)->get()->first();

            if(empty($currency->symbol)){
                $currency->symbol = $currency->code;
            }

            return view('pages.chart_of_accounts.list', [
                'company' => $company,
                'account_heads' => $account_heads,
                'currency_symbol' => $currency->symbol,
                'currency_decimal_places' => $currency->decimal_places,
                'currency_symbol_placement' => $currency->symbol_placement,
                'permission' => $permission
            ]);
        }
        else{
            return view('pages.chart_of_accounts.list');
        }    
    }

    public function debit_credit(Request $request, $parent_id){
        $head = AccountHead::where('id', $parent_id)->first();

        if($head->increased_on == 0){
            echo "<option selected value='0'>Debit</option><option value='1'>Credit</option>";
        }
        else{
            echo "<option value='0'>Debit</option><option value='1' selected>Credit</option>";
        }
    }

    public function add(Request $request){
        $comp_id = (int)$request->comp_id;
        $parent = AccountHead::where('id', $request->parent_id)->first();

        $parent->ledger = 0;
        $parent->save();

        $head = AccountHead::create([
            'comp_id' => $comp_id,
            'parent_id' => $request->parent_id,
            'name' => $request->name,
            'desc' => $request->desc,
            'increased_on' => $request->increased_on,
            'ledger' => 1,
            'root_account' => $parent->root_account
        ]);

        BalanceHistory::create([
            'acc_id' => $head->id,
            'date' => date("Y-m-d"),
            'opening_balance' => $request->balance,
            'closing_balance' => $request->balance
        ]);

        $this->updateBalances($head->root_account);
        $headcount = AccountHead::where('parent_id', $head->root_account)->count();

        // Add to Activity
        $user = Auth::user();
        $company = Company::where('id', $comp_id)->get()->first();
        $currency = Currency::where('id', $company->currency)->get()->first();
        if(empty($currency->symbol)){
            $currency->symbol = $currency->code;
        }

        $under_head = $this->parentString($parent->id, $head->root_account);


        $affected_module = 'Chart of Accounts -> '.$company->comp_name;
        $narration = $user->name." added <b>'".$head->name."'</b> to <b>".$company->comp_name."</b>'s Chart of Accounts under <b>'".$under_head."'</b> with Opening Balance: ";

        if($currency->symbol_placement == 0){
            $narration .= "<b>".$currency->symbol.number_format($request->balance, $currency->decimal_places)."</b>";
        }
        else if($currency->symbol_placement == 1){
            $narration .= "<b>".number_format($request->balance, $currency->decimal_places).$currency->symbol."</b>";
        }

        $narration .= " at <b>".date("jS-F, Y").", ".date('h:i A')."</b>.";

        Activity::create([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'affected_module' => $affected_module,
            'ref_id' => $head->id,
            'action' => 'Add',
            'narration' => $narration,
            'date' => date("Y-m-d")
        ]);

        return $parent->root_account;
    }

    private function parentString($id, $root){
        $head = AccountHead::where('id', $id)->get()->first();

        if($id == $root || $head->parent_id == 0){
            $temp = $head->name;
        }
        else{
            $temp = $this->parentString($head->parent_id, $root)."->".$head->name;
        }        
        return $temp;
    }

    private function getChildAccounts($head, $comp_id){
        $child_count = AccountHead::where('parent_id', $head->id)->where('comp_id', $comp_id)->count();

        if($child_count > 0){
            $children = AccountHead::where('parent_id', $head->id)->where('comp_id', $comp_id)->get(['id', 'comp_id', 'parent_id', 'name', 'desc', 'increased_on', 'ledger', 'root_account']);
            foreach($children as $head){
                $balance = $head->balance_history->last();

                $head->last_update_date = $balance->date;
                $head->opening_balance = $balance->opening_balance;
                $head->closing_balance = $balance->closing_balance;

                $head->children = $this->getChildAccounts($head, $comp_id);
            }
            return $children;
        }
        return;
    }


    
    private function updateBalances($id){
        $headcount = AccountHead::where('parent_id', $id)->count();

        if($headcount > 0){
            $heads = AccountHead::where('parent_id', $id)->get();

            $balance = BalanceHistory::where('acc_id', $id)->get()->last();

            $opening_sum = 0;
            $closing_sum = 0;

            foreach($heads as $head){
                $tempBalance = $this->updateBalances($head->id);

                $head_balance = BalanceHistory::where('acc_id', $head->id)->get()->last();

                $opening_sum += $tempBalance->opening_balance;
                $closing_sum += $tempBalance->closing_balance;

                if($head_balance->opening_balance != $tempBalance->opening_balance || $head_balance->closing_balance != $tempBalance->closing_balance){
                    $head_balance->date = date("Y-m-d");
                    $head_balance->opening_balance = $opening_sum;
                    $head_balance->closing_balance = $closing_sum;
                    $head_balance->save();
                }
            }

            if($balance->opening_balance != $opening_sum || $balance->closing_balance != $closing_sum){
                $balance->date = date("Y-m-d");
                $balance->opening_balance = $opening_sum;
                $balance->closing_balance = $closing_sum;
                $balance->save();
            }

            return $balance;
        }
        else{
            $balance = BalanceHistory::where('acc_id', $id)->get()->last();

            return $balance;
        }
    }
}
