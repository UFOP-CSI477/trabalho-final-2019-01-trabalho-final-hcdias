<?php

namespace PesquisaProjeto\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use \Illuminate\Support\Facades\Auth;

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
           $roles = $user->roles;
           foreach($roles as $role){
            if(in_array($role->name,$requiredPermission)){
                return true;
            }
           }
           
           return false;
        });

        Gate::define('has-actor',function($user){
            return $user->vinculo()->first() !== null;
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
