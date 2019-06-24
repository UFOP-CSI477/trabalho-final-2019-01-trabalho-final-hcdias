<?php

namespace PesquisaProjeto\Providers;

use PesquisaProjeto\LdapiAPI\LdapiAPIFacade;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;


class MinhaUfopUserProvider implements UserProvider {

	public function retrieveByToken($identifier, $token){

	}

	public function updateRememberToken(Authenticatable $user, $token){

	}

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials) ||
           (count($credentials) === 1 &&
            array_key_exists('password', $credentials))) {
            return;
        }
        
        $attributes = LdapiAPIFacade::authUserAPI($credentials);
   		
   		if( $attributes === null) return null;

        $minhaUfopModel = $this->createDynamicModel(\PesquisaProjeto\MinhaUfopUser::class);

        $query = $minhaUfopModel->newQuery();
        $result = $query->where('cpf',$credentials['email'])->first();
        
        if( !($result === null) ) return $result;

        if( $result === null ){
        	$groupModel = $this->createDynamicModel(\PesquisaProjeto\Group::class);
        	$groupUser = $groupModel
        	->where('codigo',$attributes['id_grupo'])
        	->first();
            
            if($groupUser){
                $minhaUfopModel->name = $attributes['nome'];
                $minhaUfopModel->email = $attributes['email'];
                $minhaUfopModel->cpf = $attributes['cpf'];
                $minhaUfopModel->group_id = $groupUser->id;
                $minhaUfopModel->save();
            }
        	
        }

        return $minhaUfopModel;
    }


    

    public function createDynamicModel($model)
    {
        $class = '\\'.ltrim($model, '\\');

        return new $class;
    }    

    public function validateCredentials(UserContract $user, array $credentials)
    {
       return true;
    }    

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        $model = $this->createDynamicModel(\PesquisaProjeto\MinhaUfopUser::class);
        
        return $model->newQuery()
            ->where($model->getAuthIdentifierName(), $identifier)
            ->first();
    }    
}