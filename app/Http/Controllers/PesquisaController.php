<?php

namespace PesquisaProjeto\Http\Controllers;

use Illuminate\Http\Request;
use PesquisaProjeto\Pesquisa;
use PesquisaProjeto\Professor;
use PesquisaProjeto\ProfessorPapel;
use PesquisaProjeto\Aluno;
use PesquisaProjeto\User;
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
        }elseif($request->user()->hasRole('professor')){
            if(!($professor = $request->user()->professor()->first()) == null){
                $professor_id = $professor->professor_id;
            
                $professor = Professor::find($professor_id);

                $pesquisas = $professor->pesquisas()->get();
                $pesquisas = $pesquisas->merge($pesquisas);

            }
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
        if($user->hasRole('professor')){
            if(!($professor = $user->professor()->first()) == null){
                $professorId = $professor->professor_id;
            }
        }
        
        $alunos = Aluno::all();

        return view('templates.pesquisa.create')->with([
            'professores' => $professores,
            'professorId'=>$professorId,
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

        $pesquisa = Pesquisa::findOrFail($id);

        $professorPesquisas = $pesquisa->professores()->get(['professor_id']);
        
        $professores = Professor::all();        
        $alunos = Aluno::all();
        
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
        $validation = $this->validate(request(),[
            'pesquisa_titulo'=>'required',
            'pesquisa_resumo'=>'required',
            'pesquisa_ano_inicio'=>'required',
            'pesquisa_semestre_inicio'=>'required',
            'pesquisa_status'=>'required',
            'orientador'=>'required',
            'coorientador'=>'required',
            'discentes'=>'required'
        ]);

        $orientador = $validation['orientador'];
        $coorientador = $validation['coorientador'];
        $discentes = $validation['discentes'];

        $pesquisa = Pesquisa::find($id);
        $pesquisa->pesquisa_titulo = $validation['pesquisa_titulo'];
        $pesquisa->pesquisa_resumo = $validation['pesquisa_resumo'];
        $pesquisa->pesquisa_ano_inicio = $validation['pesquisa_ano_inicio'];
        $pesquisa->pesquisa_semestre_inicio = $validation['pesquisa_semestre_inicio'];
        $pesquisa->pesquisa_status = $validation['pesquisa_status'];

        $pesquisa->save();

        $pesquisa->professores()->detach();
        foreach($discentes as $discente){
           $pesquisa->professores()->attach($orientador,
            [
                'professor_papel_id'=>ProfessorPapel::ORIENTADOR,
                'aluno_id'=>$discente
            ]);
           $pesquisa->professores()->attach($coorientador,
            [
                'professor_papel_id'=>ProfessorPapel::COORIENTADOR,
                'aluno_id'=>$discente
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
    public function destroy($id)
    {
        //
    }
}
