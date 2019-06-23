<?php

namespace PesquisaProjeto\Http\Controllers;

use Illuminate\Http\Request;
use PesquisaProjeto\Pesquisa;
use PesquisaProjeto\Professor;
use PesquisaProjeto\ProfessorPapel;
use PesquisaProjeto\Aluno;
use PesquisaProjeto\User;
use PesquisaProjeto\MinhaUfopUser;
use PesquisaProjeto\AbordagemPesquisa;
use PesquisaProjeto\Tcc;
use PesquisaProjeto\AreaPesquisa;
use PesquisaProjeto\NaturezaPesquisa;
use PesquisaProjeto\ObjetivoPesquisa;
use PesquisaProjeto\ProcedimentosPesquisa;
use PesquisaProjeto\SubAreaPesquisa;
use PesquisaProjeto\StatusPesquisa;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

class TccController extends Controller
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
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {

            $tccs = Tcc::all();
            return view('templates.tcc.index')->with('tccs', $tccs);
        }

        $role = $user->group->roles->name;
        $method = $role."Tccs";
        $tccs = $user->$method()->get();
        
        return view('templates.tcc.index')->with('tccs', $tccs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $professores = MinhaUfopUser::whereHas('group', function($query){
            $query->where('roles_id',1);
        })->get();

        $alunos = MinhaUfopUser::whereHas('group', function($query){
            $query->where('roles_id',2);
        })->get();  


        $abordagem =  AbordagemPesquisa::get();
        $area =  AreaPesquisa::get();
        $natureza =  NaturezaPesquisa::get();
        $objetivo =  ObjetivoPesquisa::get();
        $procedimento =  ProcedimentosPesquisa::get();
        $subarea =  SubAreaPesquisa::get();

        return view('templates.tcc.create')->with(
            [
            'professores' => $professores,
            'alunos'    => $alunos,
            'abordagem'=>$abordagem,
            'area'=>$area,
            'natureza'=>$natureza,
            'objetivo'=>$objetivo,
            'procedimento'=>$procedimento,
            'subarea'=>$subarea
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $tcc = $this->validate(
            request(), [
            'titulo'=>'required',
            'resumo'=>'required',
            'ano_inicio'=>'required',
            'semestre_inicio'=>'required',
            'semestre_defesa'=>'required',
            'status'=>'required',
            'orientador'=>'required',
            'coorientador'=>'required',
            'discente'=>'required',
            'abordagem'=>'required',
            'area'=>'required',
            'natureza'=>'required',
            'objetivo'=>'required',
            'procedimento'=>'required',
            'subarea'=>'required',
            'banca'=>'required'
            ]
        );
        
        $sisbin = $request->input('sisbin');
        $bancaData = $request->input('banca_data');
        
        if(!($bancaData === null)) {
            $bancaData = substr($bancaData, 6, 4)."-".substr($bancaData, 3, 2)."-".substr($bancaData, 0, 2)." ".substr($bancaData, 10);
        }

        $eventId = $this->createEvent($bancaData,$tcc['banca'],$tcc['discente']);

        if(!$eventId)
            return back()->with('error', 'Houve um erro na criação do evento');

        $resultTcc = Tcc::create(
            [
            'titulo'=>$tcc['titulo'],
            'resumo'=>$tcc['resumo'],
            'ano_inicio'=>$tcc['ano_inicio'],
            'semestre_inicio'=>$tcc['semestre_inicio'],
            'semestre_defesa'=>$tcc['semestre_defesa'],
            'status_id'=>$tcc['status'],
            'sisbin'=>$sisbin,
            'orientador_id'=>$tcc['orientador'],
            'coorientador_id'=>$tcc['coorientador'],
            'aluno_id'=>$tcc['discente'],
            'abordagem_id'=>$tcc['abordagem'],
            'area_id'=>$tcc['area'],
            'natureza_id'=>$tcc['natureza'],
            'objetivo_id'=>$tcc['objetivo'],
            'procedimentos_id'=>$tcc['procedimento'],
            'sub_area_id'=>$tcc['subarea'],
            'banca_data'=>$bancaData,
            'banca_evento_id'=>$eventId->id
            ]
        );

        foreach($tcc['banca'] as $professorBanca){
            $resultTcc->professoresBanca()->attach(
                $professorBanca,
                [
                'tcc_id' =>$resultTcc->id,
                'aluno_id' => $tcc['discente']
                ]
            );
        }

        return back()->with('success', 'Cadastro realizado com sucesso');
    }

    private function createEvent($bancaData,$professores,$discente)
    {

        $aluno = MinhaUfopUser::find($discente);

        $event = new Event;
        $event->name = "Banca de TCC - ".$aluno->name;
        $event->startDateTime = Carbon::parse($bancaData, 'UTC');
        $event->endDateTime = Carbon::parse($bancaData)->addHour();
        
        foreach($professores as $professor){
            $professor = MinhaUfopUser::find($professor);
            $event->addAttendee(['email'=>$professor->email]);
        }

        $eventId = $event->save('insertEvent', ['sendUpdates'=>'all']);
        
        return $eventId;
    }

    private function updateEvent($bancaData,$professores,$discente,$idEvento)
    {
        $aluno = MinhaUfopUser::find($discente);

        $event = Event::find($idEvento);
        $event->name = "Banca de TCC - ".$aluno->name;

        $event->startDateTime = $bancaData;
        $event->endDateTime = $event->startDateTime->addHour();

        foreach($professores as $professor){
            $professor = MinhaUfopUser::find($professor);
            $event->addAttendee(['email'=>$professor->email]);
        }

        $event->save();

    }

    private function checkEventStatus($tcc){
        
        $event = Event::find($tcc->banca_evento_id);

        if(!$event) { return false; }

        $attendees = $event->googleEvent->attendees;

        $profBanca = $tcc->professoresBanca;
        foreach($attendees as $attendee){
            if($attendee->responseStatus == 'accepted') {
                $prof = $profBanca->where('email',$attendee->email)->first();
                if($prof){
                    $tcc->professoresBanca()->updateExistingPivot($prof->id, ['status'=>1]);
                }

            }elseif($attendee->responseStatus == 'declined') {
                $prof = $profBanca->where('email',$attendee->email)->first();
                if($prof){
                    $tcc->professoresBanca()->updateExistingPivot($prof->id, ['status'=>2]);    
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $tcc = $this->getTccs($request, $id);
        if($tcc == null) {
            return response(view('403'), 403);
        }

        $aluno = $tcc->aluno()->get()->first();
        $professoresBanca = $tcc->professoresBanca()->get();

        $orientador = $tcc->orientador()->get()->first();
        $coorientador = $tcc->coorientador()->get()->first();
        
        return view('templates.tcc.detail')->with(
            [
            'tcc'=>$tcc,
            'aluno'=>$aluno,
            'orientador'=>$orientador,
            'coorientador'=>$coorientador,
            'professoresBanca'=>$professoresBanca
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function showSingleTcc(Request $request)
    {

        $user = Auth::user();
        $tcc = $user->alunoTccs;
        if(!$tcc){
            return response(view('not_created')->with(['tcc'=>'TCC','title'=>'Vishh...','link'=>'criar-tcc']), 403);
        }
        
        $eventStatus = $this->checkEventStatus($tcc);

        if(!$eventStatus)
            $warningEvent = "Houve um problema ao consultar o status dos eventos";

        $aluno = $tcc->aluno()->get()->first();
        $professoresBanca = $tcc->professoresBanca()->get();

        $orientador = $tcc->orientador()->get()->first();
        $coorientador = $tcc->coorientador()->get()->first();

        return view('templates.tcc.detail')->with(
            [
            'tcc'=>$tcc,
            'aluno'=>$aluno,
            'orientador'=>$orientador,
            'coorientador'=>$coorientador,
            'professoresBanca'=>$professoresBanca,
            'eventStatus'=>$eventStatus
            ]
        );
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {   
        $resultTcc = $this->getTccs($request, $id);
        if($resultTcc == null) {
            return response(view('403'), 403);
        }
        
        $user = Auth::user();      

        $professores = MinhaUfopUser::whereHas('group', function($query){
            $query->where('roles_id',1);
        })->get();

        $alunos = MinhaUfopUser::whereHas('group', function($query){
            $query->where('roles_id',2);
        })->get();  

        $abordagem =  AbordagemPesquisa::get();
        $area =  AreaPesquisa::get();
        $natureza =  NaturezaPesquisa::get();
        $objetivo =  ObjetivoPesquisa::get();
        $procedimento =  ProcedimentosPesquisa::get();
        $subarea =  SubAreaPesquisa::get();
        $status = StatusPesquisa::get();

        $bancaTcc = $resultTcc->professoresBanca()->get(['professor_id']);
        
        $professoresBanca = [];
        foreach($bancaTcc as $professor){
            $professoresBanca[] = $professor->professor_id;
        }
        
        return view('templates.tcc.edit')->with(
            [
            'professores'=>$professores,
            'tcc'=> $resultTcc,
            'alunos'=>$alunos,
            'abordagem'=>$abordagem,
            'area'=>$area,
            'natureza'=>$natureza,
            'objetivo'=>$objetivo,
            'procedimento'=>$procedimento,
            'subarea'=>$subarea,
            'professoresBanca'=>$professoresBanca,
            'status'=>$status
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $tcc = $this->getTccs($request, $id);

        if($tcc == null) {
            return response(view('403'), 403);
        }

        $validation = $this->validate(
            request(), [
            'titulo'=>'required',
            'resumo'=>'required',
            'ano_inicio'=>'required',
            'semestre_inicio'=>'required',
            'semestre_defesa'=>'required',
            'status'=>'required',
            'orientador'=>'required',
            'coorientador'=>'required',
            'discente'=>'required',
            'abordagem'=>'required',
            'area'=>'required',
            'natureza'=>'required',
            'objetivo'=>'required',
            'procedimento'=>'required',
            'subarea'=>'required',
            'banca'=>'required'
            ]
        );

        $sisbin = $request->input('sisbin');
        $bancaData = $request->input('banca_data');

        $professores = $validation['banca'];
        $discente = $validation['discente'];
        $idEvento = $tcc->banca_evento_id;

        if(!is_null($bancaData)) {
            $bancaData = substr($bancaData, 6, 4)."-".substr($bancaData, 3, 2)."-".substr($bancaData, 0, 2)." ".substr($bancaData, 10);
        }

        $bancaData = Carbon::parse($bancaData);
        $this->updateEvent($bancaData,$professores,$discente,$idEvento);

        $tcc->titulo = $validation['titulo'];
        $tcc->resumo = $validation['resumo'];
        $tcc->ano_inicio = $validation['ano_inicio'];
        $tcc->semestre_inicio = $validation['semestre_inicio'];
        $tcc->semestre_defesa = $validation['semestre_defesa'];
        $tcc->status_id = $validation['status'];
        $tcc->sisbin = $sisbin;
        $tcc->abordagem_id = $validation['abordagem'];
        $tcc->area_id = $validation['area'];
        $tcc->natureza_id = $validation['natureza'];
        $tcc->objetivo_id = $validation['objetivo'];
        $tcc->procedimentos_id = $validation['procedimento'];
        $tcc->sub_area_id = $validation['subarea'];
        $tcc->orientador_id = $validation['orientador'];
        $tcc->coorientador_id = $validation['coorientador'];
        $tcc->aluno_id = $validation['discente'];
        $tcc->banca_data = $bancaData;

        $tcc->save();

        $tcc->professoresBanca()->detach();
        foreach($validation['banca'] as $professorBanca){
            $tcc->professoresBanca()->attach(
                $professorBanca,
                [
                'tcc_id'=>$tcc->id,
                'aluno_id'=>$validation['discente']
                ]
            );
        }

        return back()->with('success', 'Atualizado com sucesso');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $tcc = $this->getTccs($request, $id);
        if($tcc == null) {
            return response(view('403'), 403);
        }

        $tcc->professoresBanca()->detach();
        $result = $tcc->delete($tcc->id);

        if($result) {
            return back()->with('success', 'Excluido com sucesso');
        }

        return back()->with('error', 'Houve um erro ao realizar a operação');
    }


    private function getTccs(Request $request,$id)
    {
        $user = Auth::user();
        if($user->hasRole('admin') ) {
            return Tcc::findOrFail($id);
        }

        if($user->hasRole('aluno') ) {
            return $user->alunoTccs;
        }

        $role = $user->group->roles->name;
        $method = $role."Tccs";

        return $user->$method->firstWhere('id','=',$id);        
    }
}
