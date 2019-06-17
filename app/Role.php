<?php

namespace PesquisaProjeto;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function groups()
    {
    	return $this->hasMany('PesquisaProjeto\Group','roles_id');
    }

    public function ufopUsers()
    {
    	return $this->belongsToMany('PesquisaProjeto\MinhaUfopUser');
    }
}
