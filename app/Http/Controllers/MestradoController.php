<?php

namespace PesquisaProjeto\Http\Controllers;

use Illuminate\Http\Request;
use PesquisaProjeto\Professor;
use PesquisaProjeto\ProfessorPapel;
use PesquisaProjeto\Aluno;
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
use PesquisaProjeto\Mestrado;

use Illuminate\Support\Facades\Auth;

class MestradoController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth:minhaufop-guard,web');
    }

    public function index(Request $request)
    {
    	$user = Auth::user();
        if ($user->hasRole('admin')) {
            $mestrados = Mestrado::all();
            return view('templates.mestrado.index')->with('mestrados', $mestrados);
        }

        $role = $user->group->roles->name;
        $method = $role."Mestrados";
        $mestrados = $user->$method()->get();

        return view('templates.mestrado.index')->with('mestrados', $mestrados);
    }


    public function create()
    {
        $user = Auth::user();

        $professores = MinhaUfopUser::whereHas('group', function($query){
            $query->where('roles_id',1);
        })->get();

        $alunos = MinhaUfopUser::whereHas('group', function($query){
            $query->where('roles_id',2);
        })->get();    

        $abordagem =  AbordagemPesquisa::get();
        $agencia =  AgenciaPesquisa::get();
        $area =  AreaPesquisa::get();
        $natureza =  NaturezaPesquisa::get();
        $objetivo =  ObjetivoPesquisa::get();
        $procedimento =  ProcedimentosPesquisa::get();
        $subarea =  SubAreaPesquisa::get();
        $status =  StatusPesquisa::get();

        return view('templates.mestrado.create')->with([
            'professores' => $professores,
            'alunos'    => $alunos,
            'abordagem'=>$abordagem,
            'agencia'=>$agencia,
            'area'=>$area,
            'natureza'=>$natureza,
            'objetivo'=>$objetivo,
            'procedimento'=>$procedimento,
            'subarea'=>$subarea,
            'status'=>$status
            ]);
    }

    public function store(Request $request)
    {
    	 $mestrado = $this->validate(
            request(), [
            'titulo'=>'required',
            'resumo'=>'required',
            'ano_inicio'=>'required',
            'semestre_inicio'=>'required',
            'status'=>'required',
            'orientador'=>'required',
            'coorientador'=>'required',
            'discente'=>'required',
            'abordagem'=>'required',
            'area'=>'required',
            'natureza'=>'required',
            'objetivo'=>'required',
            'procedimento'=>'required',
            'subarea'=>'required'
            ]
        );
        
        $sisbin = $request->input('sisbin_mestrado');


        $resultMestrado = Mestrado::create(
            [
            'titulo'=>$mestrado['titulo'],
            'resumo'=>$mestrado['resumo'],
            'ano_inicio'=>$mestrado['ano_inicio'],
            'semestre_inicio'=>$mestrado['semestre_inicio'],
            'status_id'=>$mestrado['status'],
            'sisbin'=>$sisbin,
            'orientador_id'=>$mestrado['orientador'],
            'coorientador_id'=>$mestrado['coorientador'],
            'aluno_id'=>$mestrado['discente'],
            'abordagem_id'=>$mestrado['abordagem'],
            'area_id'=>$mestrado['area'],
            'natureza_id'=>$mestrado['natureza'],
            'objetivo_id'=>$mestrado['objetivo'],
            'procedimentos_id'=>$mestrado['procedimento'],
            'sub_area_id'=>$mestrado['subarea']
            ]
        );

        return back()->with('success', 'Cadastro realizado com sucesso');
    }

    public function show(Request $request,$id)
    {
    	$mestrado = $this->getMestrados($request, $id);
        if($mestrado == null) {
            return response(view('403'), 403);
        }
        $aluno = $mestrado->aluno()->get()->first();

        $orientador = $mestrado->orientador()->get()->first();
        $coorientador = $mestrado->coorientador()->get()->first();
        
        return view('templates.mestrado.detail')->with(
            [
            'mestrado'=>$mestrado,
            'aluno'=>$aluno,
            'orientador'=>$orientador,
            'coorientador'=>$coorientador
            ]
        );
    }

    public function update(Request $request, $id)
    {

        $mestrado = $this->getMestrados($request, $id);

        if($mestrado == null) {
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
            'coorientador'=>'required',
            'discente'=>'required',
            'abordagem'=>'required',
            'area'=>'required',
            'natureza'=>'required',
            'objetivo'=>'required',
            'procedimento'=>'required',
            'subarea'=>'required',
            ]
        );

        $sisbin = $request->input('sisbin_mestrado');

        $mestrado->titulo = $validation['titulo'];
        $mestrado->resumo = $validation['resumo'];
        $mestrado->ano_inicio = $validation['ano_inicio'];
        $mestrado->semestre_inicio = $validation['semestre_inicio'];
        $mestrado->status_id = $validation['status'];
        $mestrado->sisbin = $sisbin;
        $mestrado->abordagem_id = $validation['abordagem'];
        $mestrado->area_id = $validation['area'];
        $mestrado->natureza_id = $validation['natureza'];
        $mestrado->objetivo_id = $validation['objetivo'];
        $mestrado->procedimentos_id = $validation['procedimento'];
        $mestrado->sub_area_id = $validation['subarea'];
        $mestrado->orientador_id = $validation['orientador'];
        $mestrado->coorientador_id = $validation['coorientador'];
        $mestrado->aluno_id = $validation['discente'];

        $mestrado->save();

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
        $resultMestrado = $this->getMestrados($request, $id);
        if($resultMestrado == null) {
            return response(view('403'), 403);
        }
        
        $professores = MinhaUfopUser::whereHas('group', function($query){
            $query->where('roles_id',1);
        })->get();

        $alunos = MinhaUfopUser::whereHas('group', function($query){
            $query->where('roles_id',2);
        })->get(); 

        $abordagem =  AbordagemPesquisa::get();
        $area =  AreaPesquisa::get();
        $natureza =  NaturezaPesquisa::get();
        $objetivo =  ObjetivoPesquisa::get();
        $procedimento =  ProcedimentosPesquisa::get();
        $subarea =  SubAreaPesquisa::get();
        $status = StatusPesquisa::get();

        return view('templates.mestrado.edit')->with(
            [
            'professores'=>$professores,
            'mestrado'=> $resultMestrado,
            'alunos'=>$alunos,
            'abordagem'=>$abordagem,
            'area'=>$area,
            'natureza'=>$natureza,
            'objetivo'=>$objetivo,
            'procedimento'=>$procedimento,
            'subarea'=>$subarea,
            'professores'=>$professores
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $mestrado = $this->getMestrados($request, $id);
        if($mestrado == null) {
            return response(view('403'), 403);
        }

        $result = $mestrado->delete($mestrado->id);

        if($result) {
            return back()->with('success', 'Excluido com sucesso');
        }

        return back()->with('error', 'Houve um erro ao realizar a operação');
    }    

    private function getMestrados(Request $request,$id)
    {
        $user = Auth::user();
        
        if( $user->hasRole('admin') ){
            return Mestrado::findOrFail($id);
        }

        $role = $user->group->roles->name;
        $method = $role."Mestrados";

        return $user->$method->firstWhere('id','=',$id);
    }
}
