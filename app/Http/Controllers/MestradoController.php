<?php

namespace PesquisaProjeto\Http\Controllers;

use Illuminate\Http\Request;
use PesquisaProjeto\Professor;
use PesquisaProjeto\ProfessorPapel;
use PesquisaProjeto\Aluno;
use PesquisaProjeto\User;
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
    	$this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if ($request->user()->hasRole('admin')) {
            $mestrados = Mestrado::all();

            return view('templates.mestrado.index')->with('mestrados', $mestrados);
        }

        if($request->user()->vinculo()->first()  == null ) {
            return response(view('403')->with('error_message', 'Nao existe ator(professor ou aluno) atrelado ao usuario. Contate o administrador.'), 403);
        }

        if($request->user()->hasRole('professor')) {
            
            $professor = $request->user()->vinculo()->first();
            $professorId = $professor->actor_id;
        
            $mestrado = Mestrado::where('orientador_mestrado_id', '=', $professorId)
            ->orWhere('coorientador_mestrado_id', '=', $professorId)
            ->get();

            $mestrados = $mestrado->merge($mestrado);
            
        }elseif($request->user()->hasRole('aluno')) {

            $aluno = $request->user()->vinculo()->first();
            $alunoId = $aluno->actor_id;
            
            $mestrado = Mestrado::where('aluno_mestrado_id', '=', $alunoId)
            ->get();

            $mestrados = $mestrado->merge($mestrado);
        }

        return view('templates.mestrado.index')->with('mestrados', $mestrados);

    }

    public function create()
    {
    	$user = Auth::user();
        $professores = Professor::all();
        $professorId = null;
        if( $user->hasRole('professor') ){
            if( !($professor = $user->vinculo()->first()) == null ){
                $professorId = $professor->actor_id;
            }
        }

        $abordagem =  AbordagemPesquisa::get();
        $agencia =  AgenciaPesquisa::get();
        $area =  AreaPesquisa::get();
        $natureza =  NaturezaPesquisa::get();
        $objetivo =  ObjetivoPesquisa::get();
        $procedimento =  ProcedimentosPesquisa::get();
        $subarea =  SubAreaPesquisa::get();
        $status =  StatusPesquisa::get();
        
        $alunos = Aluno::all();

        return view('templates.mestrado.create')->with([
            'professores' => $professores,
            'professorId'=>$professorId,
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
            'titulo_mestrado'=>'required',
            'resumo_mestrado'=>'required',
            'ano_inicio_mestrado'=>'required',
            'semestre_inicio_mestrado'=>'required',
            'status_mestrado'=>'required',
            'orientador'=>'required',
            'coorientador'=>'required',
            'discente'=>'required',
            'abordagem_mestrado'=>'required',
            'area_mestrado'=>'required',
            'natureza_mestrado'=>'required',
            'objetivo_mestrado'=>'required',
            'procedimento_mestrado'=>'required',
            'subarea_mestrado'=>'required'
            ]
        );
        
        $sisbin = $request->input('sisbin_mestrado');
        
        $user = Auth::user();
        if($user->hasRole('aluno') ) {
            if(!($aluno = $user->vinculo()->first()) == null) {
                $mestrado['discente'] = $aluno->actor_id;
            }
        }


        $resultMestrado = Mestrado::create(
            [
            'titulo_mestrado'=>$mestrado['titulo_mestrado'],
            'resumo_mestrado'=>$mestrado['resumo_mestrado'],
            'ano_inicio_mestrado'=>$mestrado['ano_inicio_mestrado'],
            'semestre_inicio_mestrado'=>$mestrado['semestre_inicio_mestrado'],
            'status_mestrado'=>$mestrado['status_mestrado'],
            'sisbin_mestrado'=>$sisbin,
            'orientador_mestrado_id'=>$mestrado['orientador'],
            'coorientador_mestrado_id'=>$mestrado['coorientador'],
            'aluno_mestrado_id'=>$mestrado['discente'],
            'abordagem_mestrado_id'=>$mestrado['abordagem_mestrado'],
            'area_mestrado_id'=>$mestrado['area_mestrado'],
            'natureza_mestrado_id'=>$mestrado['natureza_mestrado'],
            'objetivo_mestrado_id'=>$mestrado['objetivo_mestrado'],
            'procedimentos_mestrado_id'=>$mestrado['procedimento_mestrado'],
            'sub_area_mestrado_id'=>$mestrado['subarea_mestrado']
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
            'titulo_mestrado'=>'required',
            'resumo_mestrado'=>'required',
            'ano_inicio_mestrado'=>'required',
            'semestre_inicio_mestrado'=>'required',
            'status_mestrado'=>'required',
            'orientador'=>'required',
            'coorientador'=>'required',
            'discente'=>'required',
            'abordagem_mestrado'=>'required',
            'area_mestrado'=>'required',
            'natureza_mestrado'=>'required',
            'objetivo_mestrado'=>'required',
            'procedimento_mestrado'=>'required',
            'subarea_mestrado'=>'required',
            ]
        );

        $sisbin = $request->input('sisbin_mestrado');

        $mestrado->titulo_mestrado = $validation['titulo_mestrado'];
        $mestrado->resumo_mestrado = $validation['resumo_mestrado'];
        $mestrado->ano_inicio_mestrado = $validation['ano_inicio_mestrado'];
        $mestrado->semestre_inicio_mestrado = $validation['semestre_inicio_mestrado'];
        $mestrado->status_mestrado = $validation['status_mestrado'];
        $mestrado->sisbin_mestrado = $sisbin;
        $mestrado->abordagem_mestrado_id = $validation['abordagem_mestrado'];
        $mestrado->area_mestrado_id = $validation['area_mestrado'];
        $mestrado->natureza_mestrado_id = $validation['natureza_mestrado'];
        $mestrado->objetivo_mestrado_id = $validation['objetivo_mestrado'];
        $mestrado->procedimentos_mestrado_id = $validation['procedimento_mestrado'];
        $mestrado->sub_area_mestrado_id = $validation['subarea_mestrado'];
        $mestrado->orientador_mestrado_id = $validation['orientador'];
        $mestrado->coorientador_mestrado_id = $validation['coorientador'];
        $mestrado->aluno_mestrado_id = $validation['discente'];

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
        
        $professores = Professor::all();        
        $alunos = Aluno::all();

        $abordagem =  AbordagemPesquisa::get();
        $area =  AreaPesquisa::get();
        $natureza =  NaturezaPesquisa::get();
        $objetivo =  ObjetivoPesquisa::get();
        $procedimento =  ProcedimentosPesquisa::get();
        $subarea =  SubAreaPesquisa::get();
        $status = StatusPesquisa::get();

        $professores = Professor::all();
        
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

    private function getMestrados(Request $request,$id)
    {
        $mestrado = null;
        if($request->user()->hasRole('admin') ) {
            $mestrado = Mestrado::findOrFail($id);
        }elseif($request->user()->hasRole('professor') ) {
            if(!($professor = $request->user()->vinculo()->first()) == null ) {
                $professorId = $professor->actor_id;

                $mestrado = Mestrado::where('id', '=', $id)
                ->where(
                    function ($query) use ($professorId) {
                        $query->where('orientador_mestrado_id', '=', $professorId)
                            ->orWhere('coorientador_mestrado_id', '=', $professorId);
                    }
                )
                ->get()
                ->first();
            }
        }elseif($request->user()->hasRole('aluno') ) {
            if(!($aluno = $request->user()->vinculo()->first()) == null ) {
                $alunoId = $aluno->actor_id;
            
                 $mestrado = Mestrado::where('aluno_mestrado_id', '=', $alunoId)
                ->where('id', '=', $id)
                ->get()
                ->first();
            }
        }

        return $mestrado;
    }
}
