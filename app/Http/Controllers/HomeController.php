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
        $tccs      = Tcc::all()->groupBy('status_id');
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
        
        $areas      = AreaPesquisa::all();
        $status     = StatusPesquisa::all();
        $abordagens = AbordagemPesquisa::all();
        $pesquisas  = Pesquisa::all();

        $tipoProjeto = [
            1=>"Projeto de pesquisa",
            2=>"Trabalho de conclusão de curso",
            3=>"Projeto de extensão",
            4=>"Mestrado"
        ];

        return view('exibir')->with([
            'professores' => $professores,
            'areas'       => $areas,
            'status'      => $status,
            'abordagens'  => $abordagens,
            'pesquisas'   => $pesquisas,
            'tipoProjeto' => $tipoProjeto
        ]);
    }

    public function pesquisar(Request $request)
    {
        $result = $this->validate(request(),[
            'tipo_projeto_id'  =>'required',
        ]);
        
        $professorSearch  = $request->input("professor_id");
        $statusSearch     = $request->input("status_id");
        $areaSearch       = $request->input("area_id");
        $abordagemSearch  = $request->input("abordagem_id");        

        $class = '';
        switch($result['tipo_projeto_id']){
            case 1:
                $class = \PesquisaProjeto\Pesquisa::class;
                break;
            case 2:
                $class = \PesquisaProjeto\Tcc::class;
                break;
            case 3:
                $class = \PesquisaProjeto\Extensao::class;
                break;
            case 4:
                $class = \PesquisaProjeto\Mestrado::class;
                break;
            default:
                $class = \PesquisaProjeto\Pesquisa::class;
                break;
        }

        $result = $this->getData($class,$professorSearch,$statusSearch,$areaSearch,$abordagemSearch);

        $professores = MinhaUfopUser::whereHas('group', function($query){
            $query->where('roles_id',1);
        })->get();
        
        $status      = StatusPesquisa::all();
        $areas       = AreaPesquisa::all();
        $abordagens  = AbordagemPesquisa::all();
        $tipoProjeto = [
            1=>"Projeto de pesquisa",
            2=>"Trabalho de conclusão de curso",
            3=>"Projeto de extensão",
            4=>"Mestrado"
        ];

        $request->flash();
        return view('exibir')->with([
            'professores' => $professores,
            'areas'       => $areas,
            'status'      => $status,
            'abordagens'  => $abordagens,
            'tipoProjeto' => $tipoProjeto,
            'pesquisas'   => $result
        ]);          
    }

    private function getData($class, $professor = '', $status = '', $area = '', $abordagem = '')
    {
        $query = $class::query();
        $query->when($status, function($query) use ($status){
            return $query->where('status_id',$status);
        })
        ->when($area,function($query) use ($area){
            return $query->where('area_id',$area);
        })
        ->when($abordagem,function($query) use ($abordagem){
            return $query->where('abordagem_id',$abordagem);
        })
        ->when($professor,function($query) use ($professor){
            return $query->where('orientador_id',$professor);
        });

        return $query->get();
    }
}
