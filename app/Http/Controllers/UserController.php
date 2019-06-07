<?php

namespace PesquisaProjeto\Http\Controllers;

use Illuminate\Http\Request;
use PesquisaProjeto\User;
use PesquisaProjeto\Role;
use PesquisaProjeto\Professor;
use PesquisaProjeto\Aluno;
use PesquisaProjeto\VinculoUser;
use PesquisaProjeto\Departamento;
use PesquisaProjeto\Curso;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:minhaufop-guard,web');
    }

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
        
        //verifica se ha vinculo do usuario com aluno ou professor
        if($tipoVinculo !== null){
        	$vinculoUserId = $request->input('vinculo_user_id');
            //vinculo tipo 1 - professor
        	if($tipoVinculo == 1){
               //busca o professor  
        		$professor = Professor::find($vinculoUserId);
        		if($professor !== null){
                    //se existe o professor, cria o vinculo
        			$resultVinculo = VinculoUser::create([
        				'app_user_id'=>$resultUser->id,
        				'actor_id'=>$vinculoUserId,
                        'tipo_vinculo'=>$tipoVinculo
        			]);	
        		}
        	}else{
                //se existe o aluno, cria o vinculo
				$aluno = Aluno::find($vinculoUserId);
				if($aluno !== null){
					$resultVinculo = VinculoUser::create([
						'app_user_id'=>$resultUser->id,
						'actor_id'=>$vinculoUserId,
                        'tipo_vinculo'=>$tipoVinculo
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
    public function visualizarProfessor()
    {
        $user = Auth::user();     

        $vinculo = $user->vinculo()->first();
        $id_ator = $vinculo->actor_id;    

        $professorObj = Professor::find($id_ator); 
        $departamento_id = $professorObj->departamento_id;
        $departamentoObj = Departamento::find($departamento_id);

        return view('templates.simple_user.detail_professor')->with([
            'departamentos'=>$departamentoObj,
            'professores'=>$professorObj
        ]);
    }

    public function visualizarAluno(Request $request) 
    {
        $user = Auth::user();
        return view('templates.simple_user.detail_aluno')->with([
            'aluno'=>$user
        ]);
    }

    public function visualizarAdminstrador()
    {
        $user = Auth::user();

        return view('templates.simple_user.detail_admin')->with([
            'user'=>$user
        ]);
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
		$userRole = $user->group->roles;

        $vinculo = $user->vinculo()->get()->first();
        $actors = [];
        if(!is_null($vinculo)){
            if($vinculo->tipo_vinculo == 1){
                $actors = Professor::all();
            }else{
                $actors = Aluno::all();
            }    
        }
        
        return view('templates.user.edit')->with([
        	'allRoles'	=> $allRoles,
        	'userRole'	=> $userRole,
            'user'		=> $user,
            'actors'    => $actors,
            'vinculo'   => $vinculo
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
        $tipoVinculo = $request->input('tipo_vinculo');

        //procura o usuario
        $updateUser = User::findOrFail($id);
        $updateUser->name = $user['name'];
        $updateUser->email = $user['email'];
        $updateUser->password = password_hash($user['password'],PASSWORD_DEFAULT);
        
        //remove as permissões atuais
        $updateUser->roles()->detach();
        if($roles){
            foreach($roles as $role){
                $updateUser->roles()->attach($role);        
            }
        }

        //existe vinculo do usuario aos atores do sistema?
        if($tipoVinculo !== null){
            $vinculoUserId = $request->input('vinculo_user_id');
            //remove o vinculo atual
            $updateUser->vinculo()->delete();

            //vinculo tipo 1(professor)
            if($tipoVinculo == 1){
               //busca o professor  
                $professor = Professor::find($vinculoUserId);
                if($professor !== null){

                    //cria um novo vinculo
                    $vinculo = new VinculoUser();
                    $vinculo->actor_id = $vinculoUserId;
                    $vinculo->tipo_vinculo = $tipoVinculo;
                    $vinculo->user()->associate($updateUser);
                    $vinculo->save();
                    
                    //se existe o professor, cria o vinculo
                    // $resultVinculo = VinculoUser::create([
                    //     'app_user_id'=>$updateUser->id,
                    //     'actor_id'=>$vinculoUserId,
                    //     'tipo_vinculo'=>$tipoVinculo
                    // ]); 
                }
            }else{
                //se existe o aluno, cria o vinculo
                $aluno = Aluno::find($vinculoUserId);
                if($aluno !== null){
                    //cria um novo vinculo
                    $vinculo = new VinculoUser();
                    $vinculo->actor_id = $vinculoUserId;
                    $vinculo->tipo_vinculo = $tipoVinculo;
                    $vinculo->user()->associate($updateUser);
                    $vinculo->save();
                    
                }
            }   
        }

        $updateUser->save();

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
        
        $vinculoUser = VinculoUser::where('app_user_id',$user->id);
        $vinculoUser->delete();

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
    		return Professor::select('id','nome')
    		->get()
    		->toArray();
    	}elseif($id == 2){
    		return Aluno::select('id','nome')
    		->get()
    		->toArray();
    	}
    }
}
