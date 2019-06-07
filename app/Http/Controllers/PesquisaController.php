<?php

namespace PesquisaProjeto\Http\Controllers;

use Illuminate\Http\Request;
use PesquisaProjeto\Pesquisa;
use PesquisaProjeto\Professor;
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

use Illuminate\Support\Facades\Auth;

class PesquisaController extends Controller
{

    public function __construct(){
        $this->middleware('auth:minhaufop-guard,web');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if($user->hasRole('admin')){
            $pesquisas = Pesquisa::all();
            return view('templates.pesquisa.index')->with('pesquisas',$pesquisas);
        }
        
        $role = $user->group->roles->name;
        $method = $role."Pesquisas";
        $pesquisas = $user->$method()->orderBy('pesquisas.id','desc')->get();

        return view('templates.pesquisa.index')->with('pesquisas',$pesquisas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

        return view('templates.pesquisa.create')->with([
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pesquisa = $this->validate(request(),[
            'titulo'=>'required',
            'resumo'=>'required',
            'ano_inicio'=>'required',
            'semestre_inicio'=>'required',
            'status'=>'required',
            'orientador'=>'required',
            'discentes'=>'required',
            'abordagem'=>'required',
            'agencia'=>'required',
            'area'=>'required',
            'natureza'=>'required',
            'objetivo'=>'required',
            'procedimento'=>'required',
            'subarea'=>'required'
        ]);

        $discentes = $pesquisa['discentes'];
        $coorientador = $request->input('coorientador');
        $ocultarPesquisa = $request->input('ocultar') ?? 0;

        $resultPesquisa = Pesquisa::create([
            'titulo'=>$pesquisa['titulo'],
            'resumo'=>$pesquisa['resumo'],
            'ano_inicio'=>$pesquisa['ano_inicio'],
            'semestre_inicio'=>$pesquisa['semestre_inicio'],
            'status_id'=>$pesquisa['status'],
            'abordagem_id'=>$pesquisa['abordagem'],
            'agencia_id'=>$pesquisa['agencia'],
            'area_id'=>$pesquisa['area'],
            'natureza_id'=>$pesquisa['natureza'],
            'objetivo_id'=>$pesquisa['objetivo'],
            'procedimentos_id'=>$pesquisa['procedimento'],
            'sub_area_id'=>$pesquisa['subarea'],
            'orientador_id'=>$pesquisa['orientador'],
            'coorientador_id'=>$coorientador,
            'ocultar'=>$ocultarPesquisa
        ]);

        foreach($discentes as $discente){
           $resultPesquisa->alunos()->attach(
            [
                'user_id'=>$discente
            ]);
        }
        

        return back()->with('success','Cadastro realizado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        
        $pesquisa = $this->getPesquisaAtores($request,$id);
        if($pesquisa == null){
            return response(view('403'),403);
        }

        $alunos = $pesquisa->alunos()->get();

        $orientador = $pesquisa->orientador()->first();
        $coorientador = $pesquisa->coorientador()->first();
        return view('templates.pesquisa.detail')->with([
            'pesquisa'=>$pesquisa,
            'alunos'=>$alunos,
            'orientador'=>$orientador,
            'coorientador'=>$coorientador
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
   
        $pesquisa = $this->getPesquisaAtores($request,$id);
        if($pesquisa == null){
            return response(view('403'),403);
        }

       $alunosPesquisa = $pesquisa->alunos()->get();

        $professores = MinhaUfopUser::whereHas('group', function($query){
            $query->where('roles_id',1);
        })->get();

        $alunos = MinhaUfopUser::whereHas('group', function($query){
            $query->where('roles_id',2);
        })->get(); 

         
        $alunosFilter = $alunos->keyBy('id');
        foreach($alunosPesquisa as $alunoPesquisa){
            if($alunosFilter->contains('id',$alunoPesquisa->id)){
                $alunosFilter->forget($alunoPesquisa->id);
            }
        }

        $abordagem =  AbordagemPesquisa::get();
        $agencia =  AgenciaPesquisa::get();
        $area =  AreaPesquisa::get();
        $natureza =  NaturezaPesquisa::get();
        $objetivo =  ObjetivoPesquisa::get();
        $procedimento =  ProcedimentosPesquisa::get();
        $subarea =  SubAreaPesquisa::get();
        $status = StatusPesquisa::get();
             
        return view('templates.pesquisa.edit')->with([
            'alunosPesquisa'=>$alunosPesquisa,
            'professores'=>$professores,
            'pesquisa'=> $pesquisa,
            'alunos'=>$alunosFilter,
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $pesquisa = $this->getPesquisaAtores($request,$id);

        if($pesquisa == null){
            return response(view('403'),403);
        }

        $validation = $this->validate(request(),[
            'titulo'=>'required',
            'resumo'=>'required',
            'ano_inicio'=>'required',
            'semestre_inicio'=>'required',
            'status'=>'required',
            'orientador'=>'required',
            'discentes'=>'required',
            'abordagem'=>'required',
            'agencia'=>'required',
            'area'=>'required',
            'natureza'=>'required',
            'objetivo'=>'required',
            'procedimento'=>'required',
            'subarea'=>'required'
        ]);
        
        $discentes = $validation['discentes'];
        $coorientador = $request->input('coorientador');

        $pesquisa->titulo = $validation['titulo'];
        $pesquisa->resumo = $validation['resumo'];
        $pesquisa->area_id = $validation['area'];
        $pesquisa->status_id = $validation['status'];
        $pesquisa->ano_inicio = $validation['ano_inicio'];
        $pesquisa->agencia_id = $validation['agencia'];
        $pesquisa->natureza_id = $validation['natureza'];
        $pesquisa->objetivo_id = $validation['objetivo'];
        $pesquisa->sub_area_id = $validation['subarea'];
        $pesquisa->coorientador_id = $coorientador;
        $pesquisa->abordagem_id = $validation['abordagem'];
        $pesquisa->orientador_id = $validation['orientador'];
        $pesquisa->semestre_inicio = $validation['semestre_inicio'];
        $pesquisa->procedimentos_id = $validation['procedimento'];
        
        $pesquisa->save();

        $pesquisa->alunos()->detach();
        foreach($discentes as $discente){
            $pesquisa->alunos()->attach(
                [
                    'user_id'=>$discente
                ]);
        }

        return back()->with('success','Atualizado com sucesso');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $pesquisa = $this->getPesquisaAtores($request,$id);
        if($pesquisa == null){
            return response(view('403'),403);
        }

        $pesquisa->alunos()->detach();
        $result = $pesquisa->delete($pesquisa->id);

        if($result){
            return back()->with('success','Excluido com sucesso');
        }

        return back()->with('error','Houve um erro ao realizar a operação');

    }


    private function getPesquisaAtores(Request $request,$id)
    {
        $user = Auth::user();
        
        if( $user->hasRole('admin') ){
            return Pesquisa::findOrFail($id);
        }

        $role = $user->group->roles->name;
        $method = $role."Pesquisas";

        return $user->$method->firstWhere('id','=',$id);
    }
}
