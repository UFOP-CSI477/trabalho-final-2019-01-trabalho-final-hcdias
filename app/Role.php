<?php

namespace PesquisaProjeto;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users()
    {
    	return $this->belongsToMany('PesquisaProjeto\User');
    }

    public function ufopUsers()
    {
    	return $this->belongsToMany('PesquisaProjeto\MinhaUfopUser');
    }

    public function groups()
    {
    	return $this->hasMany('PesquisaProjeto\Group');
    }
}
