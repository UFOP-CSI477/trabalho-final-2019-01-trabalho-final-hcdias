<?php

namespace PesquisaProjeto\Http\Controllers;

use Illuminate\Http\Request;
use PesquisaProjeto\Professor;
use PesquisaProjeto\AreaPesquisa;
use PesquisaProjeto\AbordagemPesquisa;
use PesquisaProjeto\StatusPesquisa;
use PesquisaProjeto\Pesquisa;
use PesquisaProjeto\MinhaUfopUser;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:minhaufop-guard,web',['except'=>['exibir','pesquisar']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if($user->hasRole('admin')){
            //$this->indexAdmin($user);
        }elseif($user->hasRole('professor')){
            return $this->indexProfessor($user);
        }elseif($user->hasRole('aluno')){
            return $this->indexAluno($user);
        }

        return view('home');
    }

    protected function indexAluno(MinhaUfopUser $user){
        $pesquisas = $user->alunoPesquisas;

        if($pesquisas){
            $pesquisas = $pesquisas->groupBy('status_id');
            $pesquisasCompact = [];
            $closurePesquisas = function($item,$key) use (&$pesquisasCompact){
                $pesquisasCompact[$item->first()->status->descricao] = $item->count();
            };

            $pesquisas->each($closurePesquisas);
        }

        $tcc = $user->alunoTccs;     

        return view('home_aluno')->with(['pesquisas'=>$pesquisasCompact,'tcc'=>$tcc]);
    }

    protected function indexProfessor( $user){
        $pesquisas = $user->professorPesquisas;

        if($pesquisas){
            $pesquisas = $pesquisas->groupBy('status_id');
            $pesquisasCompact = [];
            $closurePesquisas = function($item,$key) use (&$pesquisasCompact){
                $pesquisasCompact[$item->first()->status->descricao] = $item->count();
            };

            $pesquisas->each($closurePesquisas);
        }


        $tccs = $user->professorTccs;
        if($tccs){
            $tccs = $tccs->groupBy('status_tcc');
            $tccsCompact = [];
            $closureTccs = function($item,$key) use (&$tccsCompact){
                $tccsCompact[$item->first()->status->descricao] = $item->count();
            };

            $tccs->each($closureTccs);
        }        

        return view('home');
    }

    public function exibir()
    {  
        $professores = MinhaUfopUser::whereHas('group', function($query){
            $query->where('roles_id',1);
        })->get();
        
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


        if( isset($id_professor) ){
            $professorObj = MinhaUfopUser::find($id_professor);
            $query = $professorObj->professorPesquisas();

            if(isset($id_status)){ 
                $query->where('status_id','=',$id_status);
            }

            if( isset($id_areaPesquisa) ){
                $query->where('agencia_id','=',$id_areaPesquisa);   
            }

            if( isset($id_abordagem) ){
                $query->where('abordagem_id','=',$id_abordagem);
            }

            $pesquisas = $query->get();
        }else{

           $query = Pesquisa::query();
            if(isset($id_status)){ 
                $query->where('status_id','=',$id_status);
            }

            if(isset($id_areaPesquisa)){
                $query->where('agencia_id','=',$id_areaPesquisa);   
            }

            if(isset($id_abordagem)){
                $query->where('abordagem_id','=',$id_abordagem);
            }

            $pesquisas = $query->get();
        }

        $professores = MinhaUfopUser::whereHas('group', function($query){
            $query->where('roles_id',1);
        })->get();
        
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
