<?php

namespace PesquisaProjeto;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{

	public function pesquisas()
    {
    	return $this->belongsToMany('PesquisaProjeto\Pesquisa','vinculo_pesquisas')
    		->withPivot('professor_papel_id','aluno_id');
    }

	public function tccs()
    {
    	return $this->belongsToMany('PesquisaProjeto\Tcc','banca_tccs')
    		->withPivot('professor_id','aluno_id');
    }

    public function user(){
    	return $this->hasOne('PesquisaProjeto\VinculoAlunoUser');
    }
}
