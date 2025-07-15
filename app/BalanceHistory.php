<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BalanceHistory extends Model
{
	protected $fillable = [
	'acc_id',
	'date',
	'opening_balance',
	'closing_balance'
	];
	
	public function account_head()
	{
		return $this->belongsTo('App\AccountHead', 'acc_id');
	}
}
