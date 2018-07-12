<?php

namespace PesquisaProjeto\Http\Controllers;

use Illuminate\Http\Request;
use PesquisaProjeto\User;
use PesquisaProjeto\Role;
use PesquisaProjeto\Professor;
use PesquisaProjeto\Aluno;
use PesquisaProjeto\VinculoProfessorUser;
use PesquisaProjeto\VinculoAlunoUser;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('templates.user.index')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$roles = Role::all();
        return view('templates.user.create')->with('roles',$roles);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	
        $user = $this->validate(request(),[
        	'name'=>'required|string|max:255',
        	'email'=>'required|string|email|max:255|unique:users',
        	'password'=>'required|string|min:6|confirmed'
        	]);

        $roles = $request->input('roles');
        $tipoVinculo = $request->input('tipo_vinculo');

        $resultUser = User::create([
        	'name'=>$user['name'],
        	'email'=>$user['email'],
        	'password'=>password_hash($user['password'],PASSWORD_DEFAULT)
        ]);

        if($roles){
			foreach($roles as $role){
    			$resultUser->roles()->attach($role);
    		}        	
        }
        
        if($tipoVinculo !== null){
        	$vinculo_user_id = $request->input('vinculo_user_id');
        	if($tipoVinculo == 1){
        		$professor = Professor::find($vinculo_user_id);
        		if($professor !== null){
        			$resultVinculo = VinculoProfessorUser::create([
        				'user_id'=>$resultUser->id,
        				'professor_id'=>$vinculo_user_id
        			]);	
        		}
        	}else{
				$aluno = Aluno::find($vinculo_user_id);
				if($aluno !== null){
					$resultVinculo = VinculoAlunoUser::create([
						'user_id'=>$resultUser->id,
						'aluno_id'=>$vinculo_user_id
					]);
				}
        	}	
        }

    	return back()->with('success','Usuário registrado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $allRoles = Role::all();
		$userRoles = $user->roles()->get();
		$rolesId = [];
		foreach($userRoles as $userRole){
			$rolesId[] = $userRole->id;
		}
        return view('templates.user.edit')->with([
        	'allRoles'	=> $allRoles,
        	'rolesId'	=> $rolesId,
            'user'		=> $user
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = $this->validate(request(),[
        	'name'=>'required|string|max:255',
        	'email'=>'required|string|email|max:255|unique:users,email,'.$id,
        	'password'=>'required|string|min:6|confirmed'
        	]);

        $roles = $request->input('roles');

        $updateUser = User::findOrFail($id);
        $updateUser->name = $user['name'];
        $updateUser->email = $user['email'];
        $updateUser->password = password_hash($user['password'],PASSWORD_DEFAULT);
        $updateUser->save();

        $updateUser->roles()->detach();
        if($roles){
			foreach($roles as $role){
    			$updateUser->roles()->attach($role);
    		}        	
        }

        return back()->with('success','Usuário alterado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        $user->roles()->detach();
        
        return back()->with('success','Usuário removido com sucesso');
    }


    /**
     * Lista os atores do sistema
     * @param  int $id 
     * @return array     
     */
    public function listaAtores($id)
    {
    	if($id == 1){
    		return Professor::select('id','professor_nome as nome')
    		->get()
    		->toArray();
    	}elseif($id == 2){
    		return Aluno::select('id','aluno_nome as nome')
    		->get()
    		->toArray();
    	}
    }
}
