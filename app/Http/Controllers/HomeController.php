<?php

namespace PesquisaProjeto\Http\Controllers;

use Illuminate\Http\Request;
use PesquisaProjeto\Professor;
use PesquisaProjeto\AreaPesquisa;
use PesquisaProjeto\AbordagemPesquisa;
use PesquisaProjeto\StatusPesquisa;
use PesquisaProjeto\Pesquisa;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>'exibir']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function exibir()
    {  
        $professores = Professor::all();
        $areasPesquisa = AreaPesquisa::all();
        $status = StatusPesquisa::all();
        $abordagens = AbordagemPesquisa::all();
        $pesquisas = Pesquisa::all();

        return view('exibir')->with([
            'professores' => $professores,
            'areasPesquisa' => $areasPesquisa,
            'status' => $status,
            'abordagens' => $abordagens,
            'pesquisas' => $pesquisas
        ]);
    }

    public function pesquisar(Request $request)
    {

        $id_professor = $request->input("professor_id");
        $id_status = $request->input("status_id");
        $id_areaPesquisa = $request->input("areaPesquisa_id");
        $id_abordagem = $request->input("abordagem_id");

        $professorObj = Professor::find($id_professor);

        $pesquisas = $professorObj->pesquisas()
            ->where([
                ['professor_id','=',$id_professor],
                ['status_pesquisa_id', '=' ,$id_status],
                ['agencia_pesquisa_id', '=', $id_areaPesquisa],
                ['abordagem_pesquisa_id', '=', $id_abordagem]
            ])
            ->get();  

        $professores = Professor::all();
        $status = StatusPesquisa::all();
        $areasPesquisa = AreaPesquisa::all();
        $abordagens = AbordagemPesquisa::all();

        return view('exibir')->with([
            'professores' => $professores,
            'pesquisas' => $pesquisas,
            'areasPesquisa' => $areasPesquisa,
            'status' => $status,
            'abordagens' => $abordagens,
        ]);          
    }
}
