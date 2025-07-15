<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class AccountHead extends Model
{

	protected $fillable = [
		'comp_id',
		'parent_id',
		'name',
		'desc',
		'increased_on',
		'ledger',
		'root_account'
	];

    public function balance_history()
    {
        return $this->hasMany('App\BalanceHistory', 'acc_id');
    }
}