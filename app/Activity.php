<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
	protected $fillable = [
		'user_id',
		'user_name',
		'affected_module',
		'ref_id',
		'action',
		'narration',
		'date'
	];

	public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}