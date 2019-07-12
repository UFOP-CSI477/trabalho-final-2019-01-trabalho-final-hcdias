<?php

namespace PesquisaProjeto;

use Illuminate\Database\Eloquent\Model;

class StatusTccProposta extends Model
{
    public function proposta(){
        return $this->hasMany('PesquisaProjeto\TccProposta');
    }
}
