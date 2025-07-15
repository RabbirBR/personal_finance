<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Permission;
use App\Currency;
use App\Company;
use App\AccountHead;
use App\Transaction;

class TransactionController extends Controller
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

        return view('pages.transactions.home', [
            'companies' => $companies
        ]);
    }

    public function list(Request $request, $comp_id){
        $role = Auth::user()->role;

        if($role->admin){
            $permission = new Permission;
            $permission->browse_transactions = 1;
            $permission->read_transaction = 1;
            $permission->add_transaction = 1;
            $permission->edit_transaction = 1;
            $permission->delete_transaction = 1;
        }
        else{
            $permission = Permission::where('role_id', $role->id)->where('comp_id', $comp_id)->get()->first();
        }

        if($permission->browse_transactions){
            $company = Company::where('id', $comp_id)->get()->first();
            $currency = Currency::where('id', $company->currency)->get()->first();
            $transactions =  Transaction::where('comp_id', $comp_id)->orderBy('date', 'desc')->get();

            if(empty($currency->symbol)){
                $currency->symbol = $currency->code;
            }

            $account_heads = AccountHead::where('parent_id', 0)->where('comp_id', $comp_id)->get(['id', 'comp_id', 'parent_id', 'name', 'desc', 'increased_on', 'ledger', 'root_account']);
            foreach($account_heads as $head){
                $head->children = $this->getChildAccounts($head, $comp_id);
            }

            return view('pages.transactions.list', [
                'company' => $company,
                'account_heads' => $account_heads,
                'transactions' => $transactions,
                'currency_symbol' => $currency->symbol,
                'currency_decimal_places' => $currency->decimal_places,
                'currency_symbol_placement' => $currency->symbol_placement,
                'permission' => $permission
            ]);
        }
        else{
            return view('pages.transactions.list');
        }
    }

    public function addEntry(Request $request, $comp_id){
        return $comp_id;
    }

    public function get_select(Request $request, $comp_id, $default_id){
        $account_heads = AccountHead::where('parent_id', 0)->where('comp_id', $comp_id)->get(['id', 'comp_id', 'parent_id', 'name', 'desc', 'increased_on', 'ledger', 'root_account']);
        
        foreach($account_heads as $head){
            $head->children = $this->getChildAccounts($head, $comp_id);
        }

        // return $default_id;

        return view('pages.transactions.dropdown', [
            'account_heads' => $account_heads,
            'selected_id' => $default_id
        ]);
    }

    private function getChildAccounts($head, $comp_id){
        $child_count = AccountHead::where('parent_id', $head->id)->where('comp_id', $comp_id)->count();

        if($child_count > 0){
            $children = AccountHead::where('parent_id', $head->id)->where('comp_id', $comp_id)->get(['id', 'comp_id', 'parent_id', 'name', 'desc', 'increased_on', 'ledger', 'root_account']);
            foreach($children as $head){
                $head->children = $this->getChildAccounts($head, $comp_id);
            }
            return $children;
        }
        return;
    }


}