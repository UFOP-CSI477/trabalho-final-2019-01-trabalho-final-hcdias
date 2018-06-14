<?php

namespace PesquisaProjeto\Http\Controllers;

use Illuminate\Http\Request;
use PesquisaProjeto\Pesquisa;
use PesquisaProjeto\Professor;
use PesquisaProjeto\ProfessorPapel;
use PesquisaProjeto\Aluno;
use PesquisaProjeto\User;

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

        }elseif($request->user()->hasRole('professor')){
            $professor_id = $request->user()
            ->professor()
            ->first()
            ->professor_id;
            
            $professor = Professor::find($professor_id);
            $pesquisas = $professor->pesquisas()->get();
        }
        // }elseif($request->user()->hasRole('aluno')){
        //     $aluno_id = $request->user()
        //     ->aluno()
        //     ->first()
        //     ->aluno_id;
            
        //     $aluno = Aluno::find($aluno_id);
        //     $pesquisas = $aluno->pesquisas()->get();
        // }
        return view('templates.pesquisa.index')->with('pesquisas',$pesquisas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $professores = Professor::all();
        $alunos = Aluno::all();
        return view('templates.pesquisa.create')->with([
            'professores' => $professores,
            'alunos'    => $alunos
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
            'coorientador'=>'required',
            'discentes'=>'required'
        ]);

        $orientador = $pesquisa['orientador'];
        $coorientador = $pesquisa['coorientador'];
        $discentes = $pesquisa['discentes'];

        $resultPesquisa = Pesquisa::create([
            'pesquisa_titulo'=>$pesquisa['pesquisa_titulo'],
            'pesquisa_resumo'=>$pesquisa['pesquisa_resumo'],
            'pesquisa_ano_inicio'=>$pesquisa['pesquisa_ano_inicio'],
            'pesquisa_semestre_inicio'=>$pesquisa['pesquisa_semestre_inicio'],
            'pesquisa_status'=>$pesquisa['pesquisa_status']
        ]);

        foreach($discentes as $discente){
           $resultPesquisa->professores()->attach($orientador,
            [
                'professor_papel_id'=>ProfessorPapel::ORIENTADOR,
                'aluno_id'=>$discente
            ]);
           $resultPesquisa->professores()->attach($coorientador,
            [
                'professor_papel_id'=>ProfessorPapel::COORIENTADOR,
                'aluno_id'=>$discente
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
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
		
        $pesquisa = Pesquisa::find($id);
        $professorPesquisas = $pesquisa->professores()->get(['professor_id']);
        $professores = Professor::all();
        $alunos = Aluno::all();
        
        $professorId = [];
        $alunoId = [];
        foreach($professorPesquisas as $professorPesquisa){
            $professorId[$professorPesquisa['professor_id']] = $professorPesquisa;
            $alunoId[] = $professorPesquisa['pivot']['aluno_id'];
        }
     
        return view('templates.pesquisa.edit')->with([
            'professorPesquisas'=> $professorId,
            'alunoPesquisas'=>$alunoId,
            'professores'=>$professores,
            'pesquisa'=> $pesquisa,
            'alunos'=>$alunos
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
        //
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
}
