<?php

namespace PesquisaProjeto\Http\Controllers;

use Illuminate\Http\Request;
use PesquisaProjeto\Pesquisa;
use PesquisaProjeto\Professor;
use PesquisaProjeto\ProfessorPapel;
use PesquisaProjeto\Aluno;
use PesquisaProjeto\User;
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
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->user()->hasRole('admin')) {
            $tccs = Tcc::all();

            foreach($tccs as $singleTcc){
                $eventStatus = Event::find($singleTcc->banca_evento_id);
                $profBanca = $singleTcc->professoresBanca()->get();

                foreach($eventStatus->attendees as $attendee){
                    if($attendee->responseStatus == 'accepted') {
                        foreach($profBanca as $prof){
                            if($prof->email == $attendee->email) {
                                $singleTcc->professoresBanca()->updateExistingPivot($prof->id, ['status'=>1]);
                            }
                        }
                    }elseif($attendee->responseStatus == 'declined') {
                        foreach($profBanca as $prof){
                            if($prof->email == $attendee->email) {
                                $singleTcc->professoresBanca()->updateExistingPivot($prof->id, ['status'=>2]);
                            }
                        }
                    }
                }
            }
            return view('templates.tcc.index')->with('tccs', $tccs);
        }

        if($request->user()->vinculo()->first()  == null ) {
            return response(view('403')->with('error_message', 'Nao existe ator(professor ou aluno) atrelado ao usuario. Contate o administrador.'), 403);
        }

        if($request->user()->hasRole('professor') ) {
            
            $professor = $request->user()->vinculo()->first();
            $professorId = $professor->actor_id;
        
            $tcc = Tcc::where('orientador_tcc_id', '=', $professorId)
            ->orWhere('coorientador_tcc_id', '=', $professorId)
            ->get();

            $tccs = $tcc->merge($tcc);
            foreach($tccs as $singleTcc){
                $eventStatus = Event::find($singleTcc->banca_evento_id);
                $profBanca = $singleTcc->professoresBanca()->get();

                foreach($eventStatus->attendees as $attendee){
                    if($attendee->responseStatus == 'accepted') {
                        foreach($profBanca as $prof){
                            if($prof->email == $attendee->email) {
                                $singleTcc->professoresBanca()->updateExistingPivot($prof->id, ['status'=>1]);
                            }
                        }
                    }elseif($attendee->responseStatus == 'declined') {
                        foreach($profBanca as $prof){
                            if($prof->email == $attendee->email) {
                                $singleTcc->professoresBanca()->updateExistingPivot($prof->id, ['status'=>2]);
                            }
                        }
                    }
                }
            }
            
        }elseif($request->user()->hasRole('aluno')) {

            $aluno = $request->user()->vinculo()->first();
            $alunoId = $aluno->actor_id;
            
            $tcc = Tcc::where('aluno_tcc_id', '=', $alunoId)
            ->get();

            $tccs = $tcc->merge($tcc);

            foreach($tccs as $singleTcc){
                $eventStatus = Event::find($singleTcc->banca_evento_id);
                $profBanca = $singleTcc->professoresBanca()->get();

                foreach($eventStatus->attendees as $attendee){
                    if($attendee->responseStatus == 'accepted') {
                        foreach($profBanca as $prof){
                            if($prof->email == $attendee->email) {
                                $singleTcc->professoresBanca()->updateExistingPivot($prof->id, ['status'=>1]);
                            }
                        }
                    }elseif($attendee->responseStatus == 'declined') {
                        foreach($profBanca as $prof){
                            if($prof->email == $attendee->email) {
                                $singleTcc->professoresBanca()->updateExistingPivot($prof->id, ['status'=>2]);
                            }
                        }
                    }
                }
            }
        }

        return view('templates.tcc.index')->with('tccs', $tccs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $alunoId = null;
        if($user->hasRole('aluno') ) {
            if(!($aluno = $user->vinculo()->first()) == null) {
                $alunoId = $aluno->actor_id;
            }
        }
        $professorId = null;
        if($user->hasRole('professor') ) {
            if(!($professor = $user->vinculo()->first()) == null) {
                $professorId = $professor->actor_id;
            }
        }

        $professores = Professor::all();
        $abordagem =  AbordagemPesquisa::get();
        $area =  AreaPesquisa::get();
        $natureza =  NaturezaPesquisa::get();
        $objetivo =  ObjetivoPesquisa::get();
        $procedimento =  ProcedimentosPesquisa::get();
        $subarea =  SubAreaPesquisa::get();
        
        $alunos = Aluno::all();

        return view('templates.tcc.create')->with(
            [
            'professores' => $professores,
            'alunoId'=>$alunoId,
            'professorId'=>$professorId,
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
        
        $user = Auth::user();
        if($user->hasRole('aluno') ) {
            if(!($aluno = $user->vinculo()->first()) == null) {
                $tcc['discente'] = $aluno->actor_id;
            }
        }

        $event = new Event;
        $event->name = "TCC";
        $event->startDateTime = Carbon::parse($bancaData, 'UTC');
        $event->endDateTime = Carbon::parse($bancaData)->addHour();
        $event->addAttendee(['email'=>'hugo_root@yahoo.com.br']);
        $event->addAttendee(['email'=>'hugo.dias@aluno.ufop.edu.br']);
        $event->addAttendee(['email'=>'hugocarvalhodias@hotmail.com']);
        $eventId = $event->save('insertEvent', ['sendUpdates'=>'all']);
        $event->watch(
            [
            'id'=>uniqid(),
            'type'=>'web_hook',
            'address'=>'https://de9aa8d2.ngrok.io/notification',
            'params'=>['ttl'=>3600]
            ]
        );

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
                'tcc_id'=>$resultTcc->id,
                'aluno_id'=>$tcc['discente']
                ]
            );
        }
        return back()->with('success', 'Cadastro realizado com sucesso');
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
        
        $professores = Professor::all();        
        $alunos = Aluno::all();

        $abordagem =  AbordagemPesquisa::get();
        $area =  AreaPesquisa::get();
        $natureza =  NaturezaPesquisa::get();
        $objetivo =  ObjetivoPesquisa::get();
        $procedimento =  ProcedimentosPesquisa::get();
        $subarea =  SubAreaPesquisa::get();
        $status = StatusPesquisa::get();

        $professores = Professor::all();
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
            'professores'=>$professores
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
        if(!is_null($bancaData)) {
            $bancaData = substr($bancaData, 6, 4)."-".substr($bancaData, 3, 2)."-".substr($bancaData, 0, 2)." ".substr($bancaData, 10);
        }
        $bancaData = Carbon::parse($bancaData);
        $event = Event::find($tcc->banca_evento_id);

        if(!$bancaData->equalTo(Carbon::parse($tcc->banca_data))) {
            $event->startDateTime = $bancaData;
            $event->endDateTime = $bancaData->addHour();
            $event->save();
        }

        $professoresKeyed = $tcc->professoresBanca()->get()->keyBy('id');
        if(!$professoresKeyed->contains($validation['banca_tcc'])) {

        }

        $event = new Event;
        $event->name = "TCC";
        $event->startDateTime = Carbon::parse($bancaData, 'UTC');
        $event->endDateTime = Carbon::parse($bancaData)->addHour();
        $event->addAttendee(['email'=>'hugo_root@yahoo.com.br']);
        $event->addAttendee(['email'=>'hugo.dias@aluno.ufop.edu.br']);
        $event->addAttendee(['email'=>'hugocarvalhodias@hotmail.com']);
        $eventId = $event->save('insertEvent', ['sendUpdates'=>'all']);

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
        $tcc = null;
        if($request->user()->hasRole('admin') ) {
            $tcc = Tcc::findOrFail($id);
        }elseif($request->user()->hasRole('professor') ) {
            if(!($professor = $request->user()->vinculo()->first()) == null ) {
                $professorId = $professor->actor_id;

                $tcc = Tcc::where('id', '=', $id)
                ->where(
                    function ($query) use ($professorId) {
                        $query->where('orientador_tcc_id', '=', $professorId)
                            ->orWhere('coorientador_tcc_id', '=', $professorId);
                    }
                )
                ->get()
                ->first();
            }
        }elseif($request->user()->hasRole('aluno') ) {
            if(!($aluno = $request->user()->vinculo()->first()) == null ) {
                $alunoId = $aluno->actor_id;
            
                 $tcc = Tcc::where('aluno_tcc_id', '=', $alunoId)
                ->where('id', '=', $id)
                ->get()
                ->first();
            }
        }

        return $tcc;
    }
}
