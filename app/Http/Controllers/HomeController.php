<?php

namespace PesquisaProjeto\Http\Controllers;

use Illuminate\Http\Request;
use PesquisaProjeto\AreaPesquisa;
use PesquisaProjeto\AbordagemPesquisa;
use PesquisaProjeto\StatusPesquisa;
use PesquisaProjeto\Pesquisa;
use PesquisaProjeto\Tcc;
use PesquisaProjeto\Mestrado;
use PesquisaProjeto\Extensao;
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
            return $this->indexAdmin($user);
        }elseif($user->hasRole('professor')){
            return $this->indexProfessor($user);
        }elseif($user->hasRole('aluno')){
            return $this->indexAluno($user);
        }

        return view('home');
    }

 
    /**
     * Realiza a busca e agrupamento de todos os projetos cadastrados
     * @param  [type] $user usuario autenticado
     * @return mixed array       array contendo os dados de projeto
     */
    protected function indexAluno($user){
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

    /**
     * Realiza a busca e agrupamento de todos os projetos cadastrados
     * @param  [type] $user usuario autenticado
     * @return mixed array       array contendo os dados de projeto
     */
    protected function indexAdmin($user){
        $pesquisas = Pesquisa::all()->groupBy('status_id');
        $tccs = Tcc::all()->groupBy('status_id');
        $extensoes = Extensao::all()->groupBy('status_id');
        $mestrados = Mestrado::all()->groupBy('status_mestrado');

        if($pesquisas){
            $pesquisasCompact = [];
            $closurePesquisas = function($item,$key) use (&$pesquisasCompact){
                $pesquisasCompact[$item->first()->status->id] = [
                    'desc'=> $item->first()->status->descricao, 
                    'qtd' => $item->count() 
                ];
            };

            $pesquisas->each($closurePesquisas);
        }

        if($tccs){
            $tccsCompact = [];
            $closureTccs = function($item,$key) use (&$tccsCompact){
                $tccsCompact[$item->first()->status->id] = [
                    'desc'=> $item->first()->status->descricao, 
                    'qtd' => $item->count() 
                ];
            };

            $tccs->each($closureTccs);
        }   


        if($extensoes){
            $extensoesCompact = [];
            $closureExtensoes = function($item,$key) use (&$extensoesCompact){
                $extensoesCompact[$item->first()->status->id] = [
                    'desc'=> $item->first()->status->descricao, 
                    'qtd' => $item->count() 
                ];
            };

            $extensoes->each($closureExtensoes);
        }        

        
        if($mestrados){
            $mestradosCompact = [];
            $closureMestrados = function($item,$key) use (&$mestradosCompact){
                $mestradosCompact[$item->first()->status->id] = [
                    'desc'=> $item->first()->status->descricao, 
                    'qtd' => $item->count() 
                ];
            };

            $mestrados->each($closureMestrados);
        }  
        
        return view('home_general')->with(
            [
                'pesquisas'=>json_encode($pesquisasCompact),
                'tccs'=>json_encode($tccsCompact),
                'extensoes'=>json_encode($extensoesCompact),
                'mestrados'=>json_encode($mestradosCompact)
            ]
        );        

    }


    /**
     * Realiza a busca e agrupamento de todos os projetos cadastrados
     * @param  [type] $user usuario autenticado
     * @return mixed array       array contendo os dados de projeto
     */
    protected function indexProfessor( $user){
        $pesquisas = $user->professorPesquisas;

        if($pesquisas){
            $pesquisas = $pesquisas->groupBy('status_id');
            $pesquisasCompact = [];
            $closurePesquisas = function($item,$key) use (&$pesquisasCompact){
                $pesquisasCompact[$item->first()->status->id] = [
                    'desc'=> $item->first()->status->descricao, 
                    'qtd' => $item->count() 
                ];
            };

            $pesquisas->each($closurePesquisas);
        }


        $tccs = $user->professorTccs;
        if($tccs){
            $tccs = $tccs->groupBy('status_id');
            $tccsCompact = [];
            $closureTccs = function($item,$key) use (&$tccsCompact){
                $tccsCompact[$item->first()->status->id] = [
                    'desc'=> $item->first()->status->descricao, 
                    'qtd' => $item->count() 
                ];
            };

            $tccs->each($closureTccs);
        }   

        $extensoes = $user->professorExtensoes;
        if($extensoes){
            $extensoes = $extensoes->groupBy('status_id');
            $extensoesCompact = [];
            $closureExtensoes = function($item,$key) use (&$extensoesCompact){
                $extensoesCompact[$item->first()->status->id] = [
                    'desc'=> $item->first()->status->descricao, 
                    'qtd' => $item->count() 
                ];
            };

            $extensoes->each($closureExtensoes);
        }        

        $mestrados = $user->professorMestrados;
        
        if($mestrados){
            $mestrados = $mestrados->groupBy('status_mestrado');
            $mestradosCompact = [];
            $closureMestrados = function($item,$key) use (&$mestradosCompact){
                $mestradosCompact[$item->first()->status->id] = [
                    'desc'=> $item->first()->status->descricao, 
                    'qtd' => $item->count() 
                ];
            };

            $mestrados->each($closureMestrados);
        }  

        return view('home_general')->with(
            [
                'pesquisas'=>json_encode($pesquisasCompact),
                'tccs'=>json_encode($tccsCompact),
                'extensoes'=>json_encode($extensoesCompact),
                'mestrados'=>json_encode($mestradosCompact)
            ]
        );
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
