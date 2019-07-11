<?php

namespace PesquisaProjeto;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PesquisaProjeto\User;
class MinhaUfopUser extends User
{

    protected $guard = 'minhaufop-guard';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'cpf','group_id','extra_group_id','token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token','cpf','group_id'
    ];
}
