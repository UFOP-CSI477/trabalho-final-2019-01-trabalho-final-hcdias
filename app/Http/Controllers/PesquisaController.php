<?php

namespace PesquisaProjeto\Http\Controllers;

use Illuminate\Http\Request;
use PesquisaProjeto\Pesquisa;
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

use Illuminate\Support\Facades\Auth;

class PesquisaController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->user()->hasRole('admin')){
            $pesquisas = Pesquisa::all();
            return view('templates.pesquisa.index')->with('pesquisas',$pesquisas);

        }

        if( $request->user()->vinculo()->first()  == null ){
            return response(view('403')->with('error_message','Nao existe ator(professor ou aluno) atrelado ao usuario. Contate o administrador.'),403);
        }

        if( $request->user()->hasRole('professor') ){
            
            $professor = $request->user()->vinculo()->first();
            $professorId = $professor->actor_id;
        
            $professorObj = Professor::find($professorId);

            $pesquisas = $professorObj->pesquisas()
            ->where('professor_id','=',$professorId)
            ->get();

            $pesquisas = $pesquisas->merge($pesquisas);
            

        }elseif($request->user()->hasRole('aluno')){

            $aluno = $request->user()->vinculo()->first();
            $alunoId = $aluno->actor_id;
            $alunoObj = Aluno::find($alunoId);
            $pesquisas = $alunoObj->pesquisas()
            ->where('aluno_id','=',$alunoId)
            ->get();

            $pesquisas = $pesquisas->merge($pesquisas);
        }

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
        $professores = Professor::all();
        $professorId = null;
        if( $user->hasRole('professor') ){
            if(!($professor = $user->vinculo()->first()) == null){
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
        
        $alunos = Aluno::all();

        return view('templates.pesquisa.create')->with([
            'professores' => $professores,
            'professorId'=>$professorId,
            'alunos'    => $alunos,
            'abordagem'=>$abordagem,
            'agencia'=>$agencia,
            'area'=>$area,
            'natureza'=>$natureza,
            'objetivo'=>$objetivo,
            'procedimento'=>$procedimento,
            'subarea'=>$subarea
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
            'pesquisa_titulo'=>'required',
            'pesquisa_resumo'=>'required',
            'pesquisa_ano_inicio'=>'required',
            'pesquisa_semestre_inicio'=>'required',
            'pesquisa_status'=>'required',
            'orientador'=>'required',
            'discentes'=>'required',
            'pesquisa_abordagem'=>'required',
            'pesquisa_agencia'=>'required',
            'pesquisa_area'=>'required',
            'pesquisa_natureza'=>'required',
            'pesquisa_objetivo'=>'required',
            'pesquisa_procedimento'=>'required',
            'pesquisa_subarea'=>'required'
        ]);

        $orientador = $pesquisa['orientador'];
        $discentes = $pesquisa['discentes'];
        $coorientador = $request->input('coorientador');

        $resultPesquisa = Pesquisa::create([
            'pesquisa_titulo'=>$pesquisa['pesquisa_titulo'],
            'pesquisa_resumo'=>$pesquisa['pesquisa_resumo'],
            'pesquisa_ano_inicio'=>$pesquisa['pesquisa_ano_inicio'],
            'pesquisa_semestre_inicio'=>$pesquisa['pesquisa_semestre_inicio'],
            'pesquisa_status'=>$pesquisa['pesquisa_status'],
            'abordagem_pesquisa_id'=>$pesquisa['pesquisa_abordagem'],
            'agencia_pesquisa_id'=>$pesquisa['pesquisa_agencia'],
            'area_pesquisa_id'=>$pesquisa['pesquisa_area'],
            'natureza_pesquisa_id'=>$pesquisa['pesquisa_natureza'],
            'objetivo_pesquisa_id'=>$pesquisa['pesquisa_objetivo'],
            'procedimentos_pesquisa_id'=>$pesquisa['pesquisa_procedimento'],
            'sub_area_pesquisa_id'=>$pesquisa['pesquisa_subarea'],
        ]);

        foreach($discentes as $discente){
           $resultPesquisa->professores()->attach($orientador,
            [
                'professor_papel_id'=>ProfessorPapel::ORIENTADOR,
                'aluno_id'=>$discente
            ]);

            if($coorientador){
                $resultPesquisa->professores()->attach($coorientador,
                [
                    'professor_papel_id'=>ProfessorPapel::COORIENTADOR,
                    'aluno_id'=>$discente
                ]);     
            }
        }
        

        return back()->with('success','Cadastro realizado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
     return view('templates.pesquisa.detail');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {

        
        $resultPesquisas = $this->getProfessorPesquisas($request,$id);
        if($resultPesquisas['pesquisa'] == null){
            return response(view('403'),403);
        }

        $professorPesquisas = $resultPesquisas['professorPesquisas'];
        $pesquisa = $resultPesquisas['pesquisa'];
        
        
        $professores = Professor::all();        
        $alunos = Aluno::all();

        $abordagem =  AbordagemPesquisa::get();
        $agencia =  AgenciaPesquisa::get();
        $area =  AreaPesquisa::get();
        $natureza =  NaturezaPesquisa::get();
        $objetivo =  ObjetivoPesquisa::get();
        $procedimento =  ProcedimentosPesquisa::get();
        $subarea =  SubAreaPesquisa::get();
        
        $professorId = [];
        $alunoId = [];
        foreach( $professorPesquisas as $professorPesquisa ){
            $professorId[$professorPesquisa['professor_id']] = $professorPesquisa;
            $alunoId[] = $professorPesquisa['pivot']['aluno_id'];
        }
        

        return view('templates.pesquisa.edit')->with([
            'professorPesquisas'=> $professorId,
            'alunoPesquisas'=>$alunoId,
            'professores'=>$professores,
            'pesquisa'=> $pesquisa,
            'alunos'=>$alunos,
            'abordagem'=>$abordagem,
            'agencia'=>$agencia,
            'area'=>$area,
            'natureza'=>$natureza,
            'objetivo'=>$objetivo,
            'procedimento'=>$procedimento,
            'subarea'=>$subarea
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

        $resultPesquisas = $this->getProfessorPesquisas($request,$id);

        if($resultPesquisas['pesquisa'] == null){
            return response(view('403'),403);
        }

        $professorPesquisas = $resultPesquisas['professorPesquisas'];
        $pesquisa = $resultPesquisas['pesquisa'];

        $validation = $this->validate(request(),[
            'pesquisa_titulo'=>'required',
            'pesquisa_resumo'=>'required',
            'pesquisa_ano_inicio'=>'required',
            'pesquisa_semestre_inicio'=>'required',
            'pesquisa_status'=>'required',
            'orientador'=>'required',
            'discentes'=>'required',
            'pesquisa_abordagem'=>'required',
            'pesquisa_agencia'=>'required',
            'pesquisa_area'=>'required',
            'pesquisa_natureza'=>'required',
            'pesquisa_objetivo'=>'required',
            'pesquisa_procedimento'=>'required',
            'pesquisa_subarea'=>'required'
        ]);

        $orientador = $validation['orientador'];
        $discentes = $validation['discentes'];
        $coorientador = $request->input('coorientador');

        $pesquisa->pesquisa_titulo = $validation['pesquisa_titulo'];
        $pesquisa->pesquisa_resumo = $validation['pesquisa_resumo'];
        $pesquisa->pesquisa_ano_inicio = $validation['pesquisa_ano_inicio'];
        $pesquisa->pesquisa_semestre_inicio = $validation['pesquisa_semestre_inicio'];
        $pesquisa->pesquisa_status = $validation['pesquisa_status'];
        $pesquisa->abordagem_pesquisa_id = $validation['pesquisa_abordagem'];
        $pesquisa->agencia_pesquisa_id = $validation['pesquisa_agencia'];
        $pesquisa->area_pesquisa_id = $validation['pesquisa_area'];
        $pesquisa->natureza_pesquisa_id = $validation['pesquisa_natureza'];
        $pesquisa->objetivo_pesquisa_id = $validation['pesquisa_objetivo'];
        $pesquisa->procedimentos_pesquisa_id = $validation['pesquisa_procedimento'];
        $pesquisa->sub_area_pesquisa_id = $validation['pesquisa_subarea'];

        $pesquisa->save();

        $pesquisa->professores()->detach();
        foreach($discentes as $discente){
            $pesquisa->professores()->attach($orientador,
                [
                    'professor_papel_id'=>ProfessorPapel::ORIENTADOR,
                    'aluno_id'=>$discente
                ]);
                if($coorientador){
                    $pesquisa->professores()->attach($coorientador,
                    [
                        'professor_papel_id'=>ProfessorPapel::COORIENTADOR,
                        'aluno_id'=>$discente
                     ]);     
                }  
        }

        return back()->with('success','Atualizado com sucesso');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    private function getProfessorPesquisas(Request $request,$id)
    {
        $professorPesquisas = "";
        $pesquisa = "";
        if( $request->user()->hasRole('admin') ){
            $pesquisa = Pesquisa::findOrFail($id);
            $professorPesquisas = $pesquisa->professores()->get(['professor_id']);

        }elseif( $request->user()->hasRole('professor') ){
            if( !($professor = $request->user()->vinculo()->first()) == null ){
                $professorId = $professor->actor_id;
            
                $professorObj = Professor::find($professorId);
                $actorId = $request->user()
                ->vinculo()
                ->get()
                ->first()
                ->actor_id;

                $pesquisa = $professorObj->pesquisas()->where([
                    ['professor_id','=',$actorId],
                    ['pesquisa_id','=',$id]
                ])->get()->first();

                if( !is_null($pesquisa) ){
                    $professorPesquisas = Pesquisa::find($pesquisa['id'])
                    ->professores()
                    ->get(['professor_id']);
                }
            }
        }elseif( $request->user()->hasRole('aluno') ){
            if( !($aluno = $request->user()->vinculo()->first()) == null ){
                $alunoId = $aluno->actor_id;
            
                $alunoObj = Aluno::find($alunoId);
                $actorId = $request->user()
                ->vinculo()
                ->get()
                ->first()
                ->actor_id;

                $pesquisa = $alunoObj->pesquisas()->where([
                    ['professor_id','=',$actorId],
                    ['pesquisa_id','=',$id]
                ])->get()->first();

                if( !is_null($pesquisa) ){
                    $professorPesquisas = Pesquisa::find($pesquisa['id'])
                    ->professores()
                    ->get(['professor_id']);
                }
            }
        }

        $result = [
            'professorPesquisas'=>$professorPesquisas,
            'pesquisa'=>$pesquisa
        ];

        return $result;
    }
}
