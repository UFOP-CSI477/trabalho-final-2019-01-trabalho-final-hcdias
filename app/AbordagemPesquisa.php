<?php

namespace PesquisaProjeto;

use Illuminate\Database\Eloquent\Model;

class AbordagemPesquisa extends Model
{
    public function pesquisas(){
    	return $this->hasMany('PesquisaProjeto\Pesquisa');
    }

    public function tccs(){
    	return $this->hasMany('PesquisaProjeto\Tcc');
    }
}
