<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
    	'comp_name',
        'email',
        'address',
        'city',
        'state',
        'country',
        'zip_code',
        'logo',
        'brand_color_1',
        'brand_color_2',
        'currency'
    ];

	public function permissions()
    {
        return $this->hasMany('App\Permission', 'comp_id');
    }

    public function currency()
	{
		return $this->belongsTo('App\Currency', 'currency');
	}
}