<?php

namespace PesquisaProjeto;

use Illuminate\Database\Eloquent\Model;

class VinculoProfessorUser extends Model
{
	protected $fillable = [
        'user_id', 'professor_id'
    ];
    public function user()
    {
    	return $this->belongsTo('PesquisaProjeto\User')->withDefault();
    }

    public function professor()
    {
    	return $this->belongsTo('PesquisaProjeto\Professor')->withDefault();
    }
}
