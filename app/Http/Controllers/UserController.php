<?php

namespace PesquisaProjeto\Http\Controllers;

use Illuminate\Http\Request;
use PesquisaProjeto\User;
use PesquisaProjeto\Role;
use PesquisaProjeto\Group;
use PesquisaProjeto\Aluno;
use PesquisaProjeto\MinhaUfopUser;
use PesquisaProjeto\AreaPesquisa;
use Illuminate\Support\Facades\Auth;
use PesquisaProjeto\LdapiAPI\LdapiAPIFacade;

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
        $users = MinhaUfopUser::all();
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
        return view('templates.user.create')->with('papeis',$roles);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $newUser = $this->validate(request(),[
            'cpf'=>'required|string|max:255',
            'papel'=>'required|string|max:1'
        ]);

        $role = $newUser['papel'];
        $extra_group = Role::findOrFail($role)->groups->first();
        $user = MinhaUfopUser::where('cpf',$newUser['cpf'])->get()->first();
        $result = [];
        if(!($user === null) ){
            $user->extra_group_id = $extra_group->id;
            $user->save();

            $result['status']='success';
            $result['msg']   ='Usuário registrado!';

        }else if(count($userAPI = LdapiAPIFacade::getUsersAPI($newUser['cpf'])) > 0 ){
            $group = Group::where('codigo',$userAPI['grupo'])->get()->first();
            if(!($group === null)){
                $resultUser = MinhaUfopUser::create([
                    'name'=>$userAPI['nomecompleto'],
                    'email'=>$userAPI['email'],
                    'cpf'=>$userAPI['cpf'],
                    'group_id'=>$group->id,
                    'extra_group_id'=>$extra_group->id
                ]);

                $result['status']='success';
                $result['msg']   ='Usuário registrado!';
            }else{
                $result['status']='error';
                $result['msg']   ='Grupo não encontrado!';                
            }

        }else{
            $result['status']='error';
            $result['msg']   ='Usuário não encontrado!';
        }

        return back()->with($result['status'],$result['msg']);
    }

    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */

    public function show(Request $request) 
    {
        $user = Auth::user();
        $areas = AreaPesquisa::all();
        // /dd($user->areaInteresse->all());
        return view('templates.user.detail')->with([
            'user'=>$user,
            'areas'=>$areas
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
        $user = MinhaUfopUser::findorFail($id);
        $allRoles = Role::all();
        $extraGroup = Group::find($user->extra_group_id);
        if( !($extraGroup === null) ){
            $extraGroup = $extraGroup->roles->id;
        }
        return view('templates.user.edit')->with([
            'allRoles'  => $allRoles,
            'extraGroup'=>$extraGroup,
            'user'      => $user
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

        $extraGroup = null;
        if($request->input('extraRole')){
            $userRole = $request->input('extraRole');
            $extraGroup = Role::find($userRole)->groups->first()->id;
        }

        //procura o usuario
        $updateUser = MinhaUfopUser::findOrFail($id);

        $updateUser->extra_group_id = $extraGroup;
    
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
        $user = MinhaUfopUser::findOrFail($id);
        $user->delete();

        return back()->with('success','Usuário removido com sucesso');
    }

    public function storeProfilePicture(Request $request)
    {
        $image = request()->validate([
            'profilePicture' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $atuacao   = $request->input('atuacao');
        $interesse = $request->input('interesse');
        $file      = $request->file('profilePicture');
        $user      = Auth::user();

        if($file){
            $path = $file->store('profile','public');
            if($path){
                $user->profile_picture = $path;
            }
        }

        $user->areaInteresse()->detach();
        if($atuacao){
            foreach($atuacao as $area){
                $user->areaInteresse()->attach($area);
            }
        }

        $user->area_interesse = $interesse;

        if($user->save()){
            return back()->with('success','Usuário alterado com sucesso');
        }

        return back()->with('error','Houve um erro ao realizar a operação');
    }
    /**
     * Lista os usuarios da api ldapi pelo cpf
     * @param  int $cpf
     * @return array     
     */
    public function listaAtores($cpf)
    {
       return LdapiAPIFacade::getUsersAPI($cpf);
    }
}
