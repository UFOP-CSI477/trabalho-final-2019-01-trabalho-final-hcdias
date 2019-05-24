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

        $role = $user->roles()->first()->name;
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

        $professores = MinhaUfopUser::whereHas('roles', function($query){
            $query->where('name','professor');
        })->get();

        $alunos = MinhaUfopUser::whereHas('roles', function($query){
            $query->where('name','aluno');
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
            'titulo_tcc'=>'required',
            'resumo_tcc'=>'required',
            'ano_inicio_tcc'=>'required',
            'semestre_inicio_tcc'=>'required',
            'semestre_defesa_tcc'=>'required',
            'status_tcc'=>'required',
            'orientador'=>'required',
            'coorientador'=>'required',
            'discente'=>'required',
            'abordagem_tcc'=>'required',
            'area_tcc'=>'required',
            'natureza_tcc'=>'required',
            'objetivo_tcc'=>'required',
            'procedimento_tcc'=>'required',
            'subarea_tcc'=>'required',
            'banca_tcc'=>'required'
            ]
        );
        
        $sisbin = $request->input('sisbin_tcc');
        $bancaData = $request->input('banca_data');
        
        if(!is_null($bancaData)) {
            $bancaData = substr($bancaData, 6, 4)."-".substr($bancaData, 3, 2)."-".substr($bancaData, 0, 2)." ".substr($bancaData, 10);
        }

        $eventId = $this->createEvent($bancaData,$tcc['banca_tcc'],$tcc['discente']);

        if(!$eventId)
            return back()->with('error', 'Houve um erro na criação do evento');

        $resultTcc = Tcc::create(
            [
            'titulo_tcc'=>$tcc['titulo_tcc'],
            'resumo_tcc'=>$tcc['resumo_tcc'],
            'ano_inicio_tcc'=>$tcc['ano_inicio_tcc'],
            'semestre_inicio_tcc'=>$tcc['semestre_inicio_tcc'],
            'semestre_defesa_tcc'=>$tcc['semestre_defesa_tcc'],
            'status_tcc'=>$tcc['status_tcc'],
            'sisbin_tcc'=>$sisbin,
            'orientador_tcc_id'=>$tcc['orientador'],
            'coorientador_tcc_id'=>$tcc['coorientador'],
            'aluno_tcc_id'=>$tcc['discente'],
            'abordagem_tcc_id'=>$tcc['abordagem_tcc'],
            'area_tcc_id'=>$tcc['area_tcc'],
            'natureza_tcc_id'=>$tcc['natureza_tcc'],
            'objetivo_tcc_id'=>$tcc['objetivo_tcc'],
            'procedimentos_tcc_id'=>$tcc['procedimento_tcc'],
            'sub_area_tcc_id'=>$tcc['subarea_tcc'],
            'banca_data'=>$bancaData,
            'banca_evento_id'=>$eventId->id
            ]
        );

        foreach($tcc['banca_tcc'] as $professorBanca){
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
        $event->watch(
            [
            'id'=>uniqid(),
            'type'=>'web_hook',
            'address'=>'https://188760e0.ngrok.io/notification',
            'params'=>['ttl'=>3600]
            ]
        );

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

        $professores = MinhaUfopUser::whereHas('roles', function($query){
            $query->where('name','professor');
        })->get();

        $alunos = MinhaUfopUser::whereHas('roles', function($query){
            $query->where('name','aluno');
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
            'professoresBanca'=>$professoresBanca
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
            'titulo_tcc'=>'required',
            'resumo_tcc'=>'required',
            'ano_inicio_tcc'=>'required',
            'semestre_inicio_tcc'=>'required',
            'semestre_defesa_tcc'=>'required',
            'status_tcc'=>'required',
            'orientador'=>'required',
            'coorientador'=>'required',
            'discente'=>'required',
            'abordagem_tcc'=>'required',
            'area_tcc'=>'required',
            'natureza_tcc'=>'required',
            'objetivo_tcc'=>'required',
            'procedimento_tcc'=>'required',
            'subarea_tcc'=>'required',
            'banca_tcc'=>'required'
            ]
        );

        $sisbin = $request->input('sisbin_tcc');
        $bancaData = $request->input('banca_data');

        $professores = $validation['banca_tcc'];
        $discente = $validation['discente'];
        $idEvento = $tcc->banca_evento_id;

        if(!is_null($bancaData)) {
            $bancaData = substr($bancaData, 6, 4)."-".substr($bancaData, 3, 2)."-".substr($bancaData, 0, 2)." ".substr($bancaData, 10);
        }

        $bancaData = Carbon::parse($bancaData);
        $this->updateEvent($bancaData,$professores,$discente,$idEvento);

        $tcc->titulo_tcc = $validation['titulo_tcc'];
        $tcc->resumo_tcc = $validation['resumo_tcc'];
        $tcc->ano_inicio_tcc = $validation['ano_inicio_tcc'];
        $tcc->semestre_inicio_tcc = $validation['semestre_inicio_tcc'];
        $tcc->semestre_defesa_tcc = $validation['semestre_defesa_tcc'];
        $tcc->status_tcc = $validation['status_tcc'];
        $tcc->sisbin_tcc = $sisbin;
        $tcc->abordagem_tcc_id = $validation['abordagem_tcc'];
        $tcc->area_tcc_id = $validation['area_tcc'];
        $tcc->natureza_tcc_id = $validation['natureza_tcc'];
        $tcc->objetivo_tcc_id = $validation['objetivo_tcc'];
        $tcc->procedimentos_tcc_id = $validation['procedimento_tcc'];
        $tcc->sub_area_tcc_id = $validation['subarea_tcc'];
        $tcc->orientador_tcc_id = $validation['orientador'];
        $tcc->coorientador_tcc_id = $validation['coorientador'];
        $tcc->aluno_tcc_id = $validation['discente'];
        $tcc->banca_data = $bancaData;

        $tcc->save();

        $tcc->professoresBanca()->detach();
        foreach($validation['banca_tcc'] as $professorBanca){
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

        $role = $user->roles()->first()->name;
        $method = $role."Tccs";

        return $user->$method->firstWhere('id','=',$id);        
    }
}
