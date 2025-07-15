<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class UserRole extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable =[
        'role_name',
        'admin'
    ];
    
    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function permissions()
    {
        return $this->hasMany('App\Permission', 'role_id');
    }
}