<?php

namespace PesquisaProjeto;

use Illuminate\Database\Eloquent\Model;

class VinculoUser extends Model
{
	protected $fillable = [
        'app_user_id', 'actor_id','tipo_vinculo'
    ];
    public function user()
    {
    	return $this->belongsTo('PesquisaProjeto\User','app_user_id')->withDefault();
    }
}
