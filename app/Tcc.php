<?php

namespace PesquisaProjeto;

use Illuminate\Database\Eloquent\Model;

class Tcc extends Model
{
    protected $fillable = [
		'titulo_tcc',
		'resumo_tcc',
		'ano_inicio_tcc',
		'semestre_inicio_tcc',
		'semestre_defesa_tcc',
		'status_tcc',
		'sisbin_tcc',
		'abordagem_tcc_id',
		'area_tcc_id',
		'natureza_tcc_id',
		'objetivo_tcc_id',
		'procedimentos_tcc_id',
		'sub_area_tcc_id',
		'orientador_tcc_id',
		'coorientador_tcc_id',
		'aluno_tcc_id',
		'banca_data',
        'banca_evento_id'
		];

	public function orientador(){
		return $this->belongsTo('PesquisaProjeto\Professor','orientador_tcc_id');
	}

	public function coorientador(){
		return $this->belongsTo('PesquisaProjeto\Professor','coorientador_tcc_id');
	}

	public function professoresBanca(){
    	return $this->belongsToMany('PesquisaProjeto\Professor','banca_tccs')
    		->withPivot('professor_id','aluno_id','status');
    }

    public function aluno(){
    	return $this->belongsToMany('PesquisaProjeto\Aluno','banca_tccs')
    		->withPivot('aluno_id');
    }

	public function abordagem(){
    	return $this->belongsTo('PesquisaProjeto\AbordagemPesquisa','abordagem_tcc_id');
    }


    public function area(){
    	return $this->belongsTo('PesquisaProjeto\AreaPesquisa','area_tcc_id');
    }

    public function natureza(){
    	return $this->belongsTo('PesquisaProjeto\NaturezaPesquisa','natureza_tcc_id');
    }

    public function objetivo(){
    	return $this->belongsTo('PesquisaProjeto\ObjetivoPesquisa','objetivo_tcc_id');
    }

    public function procedimento(){
    	return $this->belongsTo('PesquisaProjeto\ProcedimentosPesquisa','procedimentos_tcc_id');
    }

    public function status(){
    	return $this->belongsTo('PesquisaProjeto\StatusPesquisa','status_tcc');
    }

    public function subarea(){
    	return $this->belongsTo('PesquisaProjeto\SubAreaPesquisa','sub_area_tcc_id');
    }

}
