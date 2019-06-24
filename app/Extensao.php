<?php

namespace PesquisaProjeto;

use Illuminate\Database\Eloquent\Model;

class Extensao extends Model
{
    protected $fillable = [
		'titulo',
		'resumo',
		'ano_inicio',
		'semestre_inicio',
		'semestre_defesa',
		'status_id',
		'sisbin',
		'abordagem_id',
		'area_id',
		'sub_area_id',
		'orientador_id',
		'coorientador_id'
		];

	public function orientador(){
		return $this->belongsTo('PesquisaProjeto\MinhaUfopUser','orientador_id');
	}

	public function coorientador(){
		return $this->belongsTo('PesquisaProjeto\MinhaUfopUser','coorientador_id');
	}

    public function alunos(){
    	return $this->belongsToMany('PesquisaProjeto\MinhaUfopUser','vinculo_extensaos','extensao_id','user_id');
    }

	public function abordagem(){
    	return $this->belongsTo('PesquisaProjeto\AbordagemPesquisa','abordagem_id');
    }

    public function area(){
    	return $this->belongsTo('PesquisaProjeto\AreaPesquisa','area_id');
    }

    public function status(){
    	return $this->belongsTo('PesquisaProjeto\StatusPesquisa','status_id');
    }

    public function subarea(){
    	return $this->belongsTo('PesquisaProjeto\SubAreaPesquisa','sub_area_id');
    }
}
