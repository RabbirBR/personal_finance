<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	protected $fillable = [
		'comp_id',
		'date',
		'ref_no',
		'desc',
		'voucher',
		'amount'
	];
}
