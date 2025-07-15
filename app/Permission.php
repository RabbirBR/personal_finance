<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	protected $fillable = [
	'role_id',
	'comp_id',

	'browse_account_heads',
	'add_account_head',
	'delete_account_head',

	'browse_transactions',
	'read_transaction',
	'add_transaction',
	'edit_transaction',
	'delete_transaction',
	];

	public function role()
	{
		return $this->belongsTo('App\UserRole', 'role_id');
	}

	public function company()
	{
		return $this->belongsTo('App\Company', 'comp_id');
	}
}