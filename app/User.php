<?php

namespace PesquisaProjeto;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function group()
    {
        return $this->belongsTo('PesquisaProjeto\Group');
    }

    public function vinculo()
    {
        return $this->hasOne('PesquisaProjeto\VinculoUser','app_user_id');
    }

    public function professorPesquisas()
    {
        return $this->hasMany('PesquisaProjeto\Pesquisa','orientador_id')
        ->orWhere('coorientador_id',$this->id);
    }

    public function alunoPesquisas()
    {
        return $this->belongsToMany('PesquisaProjeto\Pesquisa','vinculo_pesquisas','user_id','pesquisa_id');

    }    

    public function professorTccs()
    {
        return $this->hasMany('PesquisaProjeto\Tcc','orientador_id')
        ->orWhere('coorientador_id',$this->id);
    }

    public function professorMestrados()
    {
        return $this->hasMany('PesquisaProjeto\Mestrado','orientador_id')
        ->orWhere('coorientador_id',$this->id);
    }

    public function alunoMestrados()
    {
        return $this->hasMany('PesquisaProjeto\Mestrado','aluno_id');
    }    
    
    public function alunoTccs()
    {
        return $this->hasOne('PesquisaProjeto\Tcc','aluno_id','id');
    }

    public function bancaTccs()
    {
        return $this->belongsToMany('PesquisaProjeto\Tcc','banca_tccs')
            ->withPivot('professor_id','aluno_id','status');
    }    

    public function alunoExtensoes()
    {
        return $this->belongsToMany('PesquisaProjeto\Extensao','vinculo_extensaos', 'user_id', 'extensao_id');
    }

    public function professorExtensoes()
    {
        return $this->hasMany('PesquisaProjeto\Extensao','orientador_id')
        ->orWhere('coorientador_id',$this->id);
    }

    public function areaAtuacao()
    {
        return $this->belongsToMany('PesquisaProjeto\AreaPesquisa','professor_areas');
    }

    public function hasAnyRole($roles)
    {

        if( !is_array($roles) && !$this->hasRole($roles) ){
            return false;
        }

        if( is_array($roles) ){
            foreach($roles as $role){
                if( $this->hasRole($role) ){
                    return true;
                }
            }
        }else{
            if($this->hasRole($roles)){
                    return true;
                }
        }

        return false;
    }

    public function hasRole($role)
    {
        $extraGroup = Group::find($this->extra_group_id);
        $extraRole = null;
        if($extraGroup){
            $extraRole = $extraGroup->roles->name;
        }

        if($this->group->roles()->where('name',$role)->first() || $extraRole == $role){
            return true;
        }

        return false;
    }
}
