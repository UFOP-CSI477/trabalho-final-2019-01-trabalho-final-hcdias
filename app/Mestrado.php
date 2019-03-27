<?php

namespace PesquisaProjeto;

use Illuminate\Database\Eloquent\Model;

class Mestrado extends Model
{
    protected $fillable = [
		'titulo_mestrado',
		'resumo_mestrado',
		'ano_inicio_mestrado',
		'semestre_inicio_mestrado',
		'semestre_defesa_mestrado',
		'status_mestrado',
		'sisbin_mestrado',
		'abordagem_mestrado_id',
		'area_mestrado_id',
		'natureza_mestrado_id',
		'objetivo_mestrado_id',
		'procedimentos_mestrado_id',
		'sub_area_mestrado_id',
		'orientador_mestrado_id',
		'coorientador_mestrado_id',
		'aluno_mestrado_id'
		];

	public function orientador(){
		return $this->belongsTo('PesquisaProjeto\Professor','orientador_mestrado_id');
	}

	public function coorientador(){
		return $this->belongsTo('PesquisaProjeto\Professor','coorientador_mestrado_id');
	}

    public function aluno(){
    	return $this->belongsTo('PesquisaProjeto\Aluno','aluno_mestrado_id');
    }

	public function abordagem(){
    	return $this->belongsTo('PesquisaProjeto\AbordagemPesquisa','abordagem_mestrado_id');
    }


    public function area(){
    	return $this->belongsTo('PesquisaProjeto\AreaPesquisa','area_mestrado_id');
    }

    public function natureza(){
    	return $this->belongsTo('PesquisaProjeto\NaturezaPesquisa','natureza_mestrado_id');
    }

    public function objetivo(){
    	return $this->belongsTo('PesquisaProjeto\ObjetivoPesquisa','objetivo_mestrado_id');
    }

    public function procedimento(){
    	return $this->belongsTo('PesquisaProjeto\ProcedimentosPesquisa','procedimentos_mestrado_id');
    }

    public function status(){
    	return $this->belongsTo('PesquisaProjeto\StatusPesquisa','status_mestrado');
    }

    public function subarea(){
    	return $this->belongsTo('PesquisaProjeto\SubAreaPesquisa','sub_area_mestrado_id');
    }
}
