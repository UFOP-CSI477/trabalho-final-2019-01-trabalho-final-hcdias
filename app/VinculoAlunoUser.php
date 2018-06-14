<?php

namespace PesquisaProjeto;

use Illuminate\Database\Eloquent\Model;

class VinculoAlunoUser extends Model
{
	protected $fillable = [
        'user_id', 'aluno_id'
    ];
    public function user(){
    	return $this->belongsTo('PesquisaProjeto\User')->withDefault();
    }

    public function aluno(){
    	return $this->belongsTo('PesquisaProjeto\Aluno')->withDefault();
    }
}
