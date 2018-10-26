<?php

namespace PesquisaProjeto;

use Illuminate\Database\Eloquent\Model;

class Tcc extends Model
{
    protected $fillable = [
		'tcc_titulo',
		'tcc_resumo',
		'tcc_ano_inicio',
		'tcc_semestre_inicio',
		'tcc_semestre_defesa',
		'tcc_status',
		'tcc_sisbin',
		'abordagem_tcc_id',
		'agencia_tcc_id',
		'area_tcc_id',
		'natureza_tcc_id',
		'objetivo_tcc_id',
		'procedimentos_tcc_id',
		'sub_area_tcc_id',
		'orientador_tcc_id',
		'coorientador_tcc_id',
		'aluno_tcc_id'
		];
}
