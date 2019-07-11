<?php

namespace PesquisaProjeto\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use \Illuminate\Support\Facades\Auth;
use PesquisaProjeto\Group;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'PesquisaProjeto\Model' => 'PesquisaProjeto\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('minhaufopuserprovider', function($app, array $config) {
            return new MinhaUfopUserProvider($app['hash'],$config['model']);
        });       

        Gate::define('show-menu',function($user,$requiredPermission){
           $role = $user->group->roles;
           $extraRole = null;
           if(!($user->extra_group_id === null)){
                $extraRole = Group::find($user->extra_group_id)->roles->name;
           }
           
            if(in_array($role->name,$requiredPermission) || in_array($extraRole,$requiredPermission)){
                return true;
            }
           
           return false;
        });

        Gate::define('receive-notifications',function($user){
            return auth()->check();
        });

        Gate::define('admin',function($user){
            return $user->hasRole('admin');
        });

        Gate::define('professor',function($user){
            return $user->hasRole('professor');
        });

        Gate::define('aluno',function($user){
            return $user->hasRole('aluno');
        });
    }
}
