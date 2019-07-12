<?php

namespace PesquisaProjeto\Http\Controllers;

use PesquisaProjeto\TccProposta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use PesquisaProjeto\AreaPesquisa;
use PesquisaProjeto\MinhaUfopUser;
use PesquisaProjeto\Http\Requests\TccPropostaRequest;
use PesquisaProjeto\StatusTccProposta;
class TccPropostaController extends Controller
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
    public function index(TccProposta $model)
    {
        $propostas = $model->all()->filter(function($proposta){
            return $proposta->aluno_id = Auth::user()->id;
        });

        return view('templates.propostaTcc.index',['propostas'=>$propostas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(TccProposta $model)
    {
        $areas = AreaPesquisa::all();
        $professores = MinhaUfopUser::whereHas('group', function($query){
            $query->where('roles_id',1);
        })->get();

        return view('templates.propostaTcc.create',['professores'=>$professores,'areas'=>$areas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TccPropostaRequest $request, TccProposta $model)
    {
        $model->create($request->merge([
            'aluno_id'=>Auth::user()->id,
            'status_id'=>1
        ])->all());

        return redirect()->route('visualizar_proposta')->with('success','Proposta enviada!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \PesquisaProjeto\TccProposta  $tccProposta
     * @return \Illuminate\Http\Response
     */
    public function show($tccProposta)
    {
        $proposta = TccProposta::findorFail($tccProposta);
        $status = StatusTccProposta::all();
        return view('templates.propostaTcc.detail',['proposta'=>$proposta,'status'=>$status]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \PesquisaProjeto\TccProposta  $tccProposta
     * @return \Illuminate\Http\Response
     */
    public function edit(TccProposta $proposta)
    {
        $areas = AreaPesquisa::all();
        return view('templates.propostaTcc.edit', ['proposta'=>$proposta,'areas'=>$areas]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \PesquisaProjeto\TccProposta  $tccProposta
     * @return \Illuminate\Http\Response
     */
    public function update(TccPropostaRequest $request, $tccProposta)
    {
        $proposta = TccProposta::findOrFail($tccProposta);
        $proposta->update($request->all());
        return redirect()->route('visualizar_proposta')->with('success','Proposta alterada!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \PesquisaProjeto\TccProposta  $tccProposta
     * @return \Illuminate\Http\Response
     */
    public function destroy($tccProposta)
    {
        $proposta = TccProposta::findOrFail($tccProposta);
        $result = $proposta->delete($tccProposta);

        if($result) {
            return back()->with('success', 'Excluido com sucesso');
        }

        return back()->with('error', 'Houve um erro ao realizar a operação');
    }

    /**
     * Retorna os professores da area de interesse selecionada
     *
     * @param  \PesquisaProjeto\AreaPesquisa $area
     * @return \Illuminate\Http\Response
     */
    public function areaInteresseProfessor($id)
    {
        $areas = AreaPesquisa::findorFail($id);
        return $areas->professores;
    }

    /**
     * Retorna as propostas recebidas pelo professor
     *
     * @param  \PesquisaProjeto\AreaPesquisa $area
     * @return \Illuminate\Http\Response
     */
    public function showPropostasProfessor(TccProposta $model)
    {
        $propostas = $model->all()->filter(function($proposta){
            return $proposta->orientador_id == Auth::user()->id;
        });
        
        return view('templates.propostaTcc.index',['propostas'=>$propostas]);
    }

 

    /**
     * Altera o status da proposta
     *
     * @param  \PesquisaProjeto\TccProposta  $tccProposta
     * @return \Illuminate\Http\Response
     */
    public function updatePropostaProfessor(Request $request, $tccProposta)
    {
        $proposta = TccProposta::findOrFail($tccProposta);

        $proposta->status_id = $request->get('status_id');
        $proposta->save();
        return redirect()->route('visualizar_proposta_professor')->with('success','Proposta alterada!');
    }
}
