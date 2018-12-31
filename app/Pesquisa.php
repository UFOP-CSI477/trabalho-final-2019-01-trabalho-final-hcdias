<?php

namespace PesquisaProjeto;

use Illuminate\Database\Eloquent\Model;

class Pesquisa extends Model
{
	protected $fillable = [
		'pesquisa_titulo',
		'pesquisa_resumo',
		'pesquisa_ano_inicio',
		'pesquisa_semestre_inicio',
		'status_pesquisa_id',
		'abordagem_pesquisa_id',
		'agencia_pesquisa_id',
		'area_pesquisa_id',
		'natureza_pesquisa_id',
		'objetivo_pesquisa_id',
		'procedimentos_pesquisa_id',
		'sub_area_pesquisa_id'
		];
	 
    public function professores(){
    	return $this->belongsToMany('PesquisaProjeto\Professor','vinculo_pesquisas')
    		->withPivot('professor_papel_id','aluno_id');
    }

    public function alunos(){
    	return $this->belongsToMany('PesquisaProjeto\Aluno','vinculo_pesquisas')
    		->withPivot('professor_papel_id','aluno_id');
    }

	public function abordagem(){
    	return $this->belongsTo('PesquisaProjeto\AbordagemPesquisa','abordagem_pesquisa_id');
    }

	public function agencia(){
    	return $this->belongsTo('PesquisaProjeto\AgenciaPesquisa','agencia_pesquisa_id');
    }

    public function area(){
    	return $this->belongsTo('PesquisaProjeto\AreaPesquisa','area_pesquisa_id');
    }

    public function natureza(){
    	return $this->belongsTo('PesquisaProjeto\NaturezaPesquisa','natureza_pesquisa_id');
    }

    public function objetivo(){
    	return $this->belongsTo('PesquisaProjeto\ObjetivoPesquisa','objetivo_pesquisa_id');
    }

    public function procedimento(){
    	return $this->belongsTo('PesquisaProjeto\ProcedimentosPesquisa','procedimentos_pesquisa_id');
    }

    public function status(){
    	return $this->belongsTo('PesquisaProjeto\StatusPesquisa','status_pesquisa_id');
    }

    public function subarea(){
    	return $this->belongsTo('PesquisaProjeto\SubAreaPesquisa','sub_area_pesquisa_id');
    }
}
