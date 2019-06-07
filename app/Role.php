<?php

namespace PesquisaProjeto;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function groups()
    {
    	return $this->hasOne('PesquisaProjeto\Group');
    }

    public function ufopUsers()
    {
    	return $this->belongsToMany('PesquisaProjeto\MinhaUfopUser');
    }
}
