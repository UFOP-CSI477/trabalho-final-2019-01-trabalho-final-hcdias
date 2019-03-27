<?php

namespace PesquisaProjeto;

use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
	protected $table = 'professores';
	
    public function pesquisas()
    {
    	return $this->belongsToMany('PesquisaProjeto\Pesquisa','vinculo_pesquisas')
    		->withPivot('professor_papel_id','aluno_id');
    }

    public function bancaTccs()
    {
        return $this->belongsToMany('PesquisaProjeto\Tcc','banca_tccs')
            ->withPivot('professor_id','aluno_id','status');
    }

    public function user()
    {
    	return $this->hasOne('PesquisaProjeto\VinculoProfessorUser');
    }

    public function tccs(){
        return $this->hasMany('PesquisaProjeto\Tcc');
    }

    public function mestrados(){
        return $this->hasMany('PesquisaProjeto\Mestrado');
    }
    
}
