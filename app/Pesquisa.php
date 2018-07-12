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
		'pesquisa_status',
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
}
