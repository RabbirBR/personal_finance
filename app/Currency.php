<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
    	'name',
    	'symbol',
    	'code',
    	'decimal_places',
    	'symbol_placement',
    ];

    public function companies()
    {
        return $this->hasMany('App\Company', 'currency');
    }
}