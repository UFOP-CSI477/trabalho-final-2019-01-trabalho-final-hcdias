<?php

namespace PesquisaProjeto;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function roles()
    {
    	return $this->belongsTo('PesquisaProjeto\Role');
    }
}
