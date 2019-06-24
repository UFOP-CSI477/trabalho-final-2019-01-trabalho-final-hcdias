<?php

namespace PesquisaProjeto\Http\Controllers;

use Illuminate\Http\Request;
use PesquisaProjeto\User;
use PesquisaProjeto\MinhaUfopUser;
use PesquisaProjeto\AbordagemPesquisa;
use PesquisaProjeto\AgenciaPesquisa;
use PesquisaProjeto\AreaPesquisa;
use PesquisaProjeto\NaturezaPesquisa;
use PesquisaProjeto\ObjetivoPesquisa;
use PesquisaProjeto\ProcedimentosPesquisa;
use PesquisaProjeto\SubAreaPesquisa;
use PesquisaProjeto\StatusPesquisa;
use PesquisaProjeto\Extensao;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ExtensaoController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth:minhaufop-guard,web');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $extensao = Extensao::all();
            return view('templates.extensao.index')->with('extensoes', $extensao);
        }

        $role = $user->group->roles->name;
        $method = $role."Extensoes";
        $extensao = $user->$method()->get();

        return view('templates.extensao.index')->with('extensoes', $extensao);
    }


    public function create()
    {

        $professores = MinhaUfopUser::whereHas('group', function($query){
            $query->where('roles_id',1);
        })->get();

        $alunos = MinhaUfopUser::whereHas('group', function($query){
            $query->where('roles_id',2);
        })->get();  

        $abordagem =  AbordagemPesquisa::get();
        $agencia =  AgenciaPesquisa::get();
        $area =  AreaPesquisa::get();
        $subarea =  SubAreaPesquisa::get();
        $status =  StatusPesquisa::get();
        

        return view('templates.extensao.create')->with([
            'professores' => $professores,
            'alunos'    => $alunos,
            'abordagem'=>$abordagem,
            'agencia'=>$agencia,
            'area'=>$area,
            'subarea'=>$subarea,
            'status'=>$status
            ]);
    }

    public function store(Request $request)
    {

    	 $extensao = $this->validate(
            request(), [
            'titulo'=>'required',
            'resumo'=>'required',
            'ano_inicio'=>'required',
            'semestre_inicio'=>'required',
            'status'=>'required',
            'orientador'=>'required',
            'discentes'=>'required',
            'abordagem'=>'required',
            'area'=>'required',
            'subarea'=>'required'
            ]
        );
        
        $sisbin = $request->input('sisbin');
        $discentes = $extensao['discentes'];
        $coorientador = $request->input('coorientador');        
        
        $resultExtensao = Extensao::create(
            [
            'titulo'=>$extensao['titulo'],
            'resumo'=>$extensao['resumo'],
            'ano_inicio'=>$extensao['ano_inicio'],
            'semestre_inicio'=>$extensao['semestre_inicio'],
            'status_id'=>$extensao['status'],
            'sisbin'=>$sisbin,
            'orientador_id'=>$extensao['orientador'],
            'coorientador_id'=>$coorientador,
            'abordagem_id'=>$extensao['abordagem'],
            'area_id'=>$extensao['area'],
            'sub_area_id'=>$extensao['subarea']
            ]
        );


        foreach($discentes as $discente){
           $resultExtensao->alunos()->attach(
            [
                'user_id'=>$discente
            ]);
        }        

        return back()->with('success', 'Cadastro realizado com sucesso');
    }

    public function show(Request $request,$id)
    {
    	$extensao = $this->getExtensoes($request, $id);
        if($extensao == null) {
            return response(view('403'), 403);
        }

        $alunos = $extensao->alunos()->get();

        $orientador = $extensao->orientador()->get()->first();
        $coorientador = $extensao->coorientador()->get()->first();
        
        return view('templates.extensao.detail')->with(
            [
            'extensao'=>$extensao,
            'alunos'=>$alunos,
            'orientador'=>$orientador,
            'coorientador'=>$coorientador
            ]
        );
    }

    public function update(Request $request, $id)
    {

        $extensao = $this->getExtensoes($request, $id);

        if($extensao == null) {
            return response(view('403'), 403);
        }

        $validation = $this->validate(
            request(), [
            'titulo'=>'required',
            'resumo'=>'required',
            'ano_inicio'=>'required',
            'semestre_inicio'=>'required',
            'status'=>'required',
            'orientador'=>'required',
            'discentes'=>'required',
            'abordagem'=>'required',
            'area'=>'required',
            'subarea'=>'required',
            ]
        );

        $sisbin = $request->input('sisbin');
        $discentes = $validation['discentes'];
        $coorientador = $request->input('coorientador');     

        $extensao->titulo = $validation['titulo'];
        $extensao->resumo = $validation['resumo'];
        $extensao->ano_inicio = $validation['ano_inicio'];
        $extensao->semestre_inicio = $validation['semestre_inicio'];
        $extensao->status_id = $validation['status'];
        $extensao->sisbin = $sisbin;
        $extensao->abordagem_id = $validation['abordagem'];
        $extensao->area_id = $validation['area'];
        $extensao->sub_area_id = $validation['subarea'];
        $extensao->orientador_id = $validation['orientador'];
        $extensao->coorientador_id = $coorientador;

        $extensao->save();
        $extensao->alunos()->detach();
        foreach($discentes as $discente){
            $extensao->alunos()->attach(
                [
                    'user_id'=>$discente
                ]);
        }        

        return back()->with('success', 'Atualizado com sucesso');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {   
        $resultExtensao = $this->getExtensoes($request, $id);
        if($resultExtensao == null) {
            return response(view('403'), 403);
        }

        $abordagem =  AbordagemPesquisa::get();
        $area =  AreaPesquisa::get();
        $natureza =  NaturezaPesquisa::get();
        $objetivo =  ObjetivoPesquisa::get();
        $procedimento =  ProcedimentosPesquisa::get();
        $subarea =  SubAreaPesquisa::get();
        $status = StatusPesquisa::get();

        $alunosExtensao = $resultExtensao->alunos()->get();

        $professores = MinhaUfopUser::whereHas('group', function($query){
            $query->where('roles_id',1);
        })->get();

        $alunos = MinhaUfopUser::whereHas('group', function($query){
            $query->where('roles_id',2);
        })->get();  
        
        $alunosFilter = $alunos->keyBy('id');
        foreach($alunosExtensao as $alunoExtensao){
            if($alunosFilter->contains('id',$alunoExtensao->id)){
                $alunosFilter->forget($alunoExtensao->id);
            }
        }

        return view('templates.extensao.edit')->with(
            [
            'professores'=>$professores,
            'extensao'=> $resultExtensao,
            'alunos'=>$alunosFilter,
            'alunosExtensao'=>$alunosExtensao,
            'abordagem'=>$abordagem,
            'area'=>$area,
            'natureza'=>$natureza,
            'objetivo'=>$objetivo,
            'procedimento'=>$procedimento,
            'subarea'=>$subarea,
            'status'=>$status
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $extensao = $this->getExtensoes($request,$id);
        if($extensao == null){
            return response(view('403'),403);
        }

        $extensao->alunos()->detach();
        $result = $extensao->delete($extensao->id);

        if($result){
            return back()->with('success','Excluido com sucesso');
        }

        return back()->with('error','Houve um erro ao realizar a operação');

    }

    private function getExtensoes(Request $request,$id)
    {
        $user = Auth::user();
        
        if( $user->hasRole('admin') ){
            return Extensao::findOrFail($id);
        }


        $role = $user->group->roles->name;
        $method = $role."Extensoes";

        return $user->$method->firstWhere('id','=',$id);
    }

}
