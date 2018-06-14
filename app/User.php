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

    public function roles()
    {
        return $this->belongsToMany('PesquisaProjeto\Role');
    }

    public function aluno()
    {
        return $this->hasOne('PesquisaProjeto\VinculoAlunoUser');
    }

    public function professor()
    {
        return $this->hasOne('PesquisaProjeto\VinculoProfessorUser');
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
        if($this->roles()->where('name',$role)->first()){
            return true;
        }

        return false;
    }
}
