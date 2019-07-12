<?php

namespace PesquisaProjeto;

use Illuminate\Database\Eloquent\Model;
use PesquisaProjeto\Traits\TccPropostaEventsTrait;
class TccProposta extends Model
{

    use TccPropostaEventsTrait;

    protected $fillable = [
        'orientador_id',
        'coorientador_id',
        'aluno_id',
        'area_id',
        'titulo', 
        'descricao',
        'status_id'
    ];

    public function orientador()
    {
        return $this->belongsTo('PesquisaProjeto\MinhaUfopUser','orientador_id');
    }

    public function coorientador()
    {
        return $this->belongsTo('PesquisaProjeto\MinhaUfopUser','coorientador_id');
    }    

    public function aluno(){
        return $this->belongsTo('PesquisaProjeto\MinhaUfopUser','aluno_id');
    } 

    public function area(){
        return $this->belongsTo('PesquisaProjeto\AreaPesquisa','area_id');
    } 

    public function status(){
        return $this->belongsTo('PesquisaProjeto\StatusTccProposta','status_id');
    }    
}
