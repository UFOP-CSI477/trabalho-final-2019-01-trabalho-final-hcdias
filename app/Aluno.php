<?php

namespace PesquisaProjeto;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    public function user(){
    	return $this->hasOne('PesquisaProjeto\VinculoAlunoUser');
    }
}
