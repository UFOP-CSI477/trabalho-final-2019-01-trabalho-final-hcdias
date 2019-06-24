@extends('adminlte::page')
	@section('content')
	<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Trabalho de Conclusão de Curso
        <small>detalhes do trabalho e banca de avaliação</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">TCCs</a></li>
        <li class="active">detalhes</li>
      </ol>
    </section>
      <section class="content">
        <div class="row">
          <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title">Integrantes</h3>
                </div>
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                      <li style="width:30%">
                        <img src="{{ $orientador->profile_picture ? asset('storage/'.$orientador->profile_picture) : '/media/mario.png'}}">
                        <a href="#" class="users-list-name">{{$orientador->nome}}</a>
                        <span class="users-list-date">Orientador</span>
                         <span class="users-list-date">{{ $orientador->email }}</span>
                      </li>  
                      <li style="width:30%">
                        <img src="{{ $coorientador->profile_picture ? asset('storage/'.$coorientador->profile_picture) : '/media/mario.png'}}">
                        <a href="#" class="users-list-name">{{$coorientador->nome}}</a>
                        <span class="users-list-date">Coorientador</span>
                         <span class="users-list-date">{{ $coorientador->email }}</span>
                      </li>  
                      <li style="width:30%">
                        <img src="{{ $aluno->profile_picture ? asset('storage/'.$aluno->profile_picture) : '/media/mario.png'}}">
                        <a href="#" class="users-list-name">{{$aluno->nome}}</a>
                        <span class="users-list-date">Orientando</span>
                        <span class="users-list-date">{{$aluno->email}}</span>
                      </li> 
                  </ul>
                </div>
              </div>
            </div>
        </div>
            <div class="box box-primary">
              <div class="box-header">
                <h3 class="box-title">Banca de Avaliação</h3>
              </div>
              <div class="box-body no-padding">
                <div class="row">
          
                  <div class="col-md-12">
                    <ul class="users-list clearfix">
                      @foreach($professoresBanca as $professorBanca)
                        <li>
                          <img src="{{ $professorBanca->profile_picture ? asset('storage/'.$professorBanca->profile_picture) : '/media/mario.png'}}" title="{{ $professorBanca->email }}">
                          <a href="#" class="users-list-name">{{$professorBanca->name}}</a>
                            @if($professorBanca->pivot->status == 1)
                              <span class="label-alert-status-banca-{{$professorBanca->pivot->status}}" title="Confirmado">
                                <i class="fa fa-check-square-o"></i>
                              </span>
                            @elseif($professorBanca->pivot->status == 2) 
                              <span class="label-alert-status-banca-{{$professorBanca->pivot->status}}" title="Recusado">
                                <i class="fa fa-fw fa-remove"></i>
                              </span>
                            @else
                              <span class="label-alert-status-banca-{{$professorBanca->pivot->status}}" title="Aguardando">
                                <i class="fa fa-fw fa-hourglass-3"></i>
                              </span>
                            @endif
                          </span>
                        </li>  
                      @endforeach
                    </ul>
                  </div>
                </div>
           </div>
          </div>
      </section>

      <section class="content">
        <div class="row">
          <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title">Detalhes do projeto </h3>
                </div>
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-6">
                      <p class="lead text-muted"> Título: {{$tcc->titulo}}</p>
                    </div>
                    <div class="col-md-6">
                      <p class="lead text-status-{{$tcc->status()->get()->first()->id}}">Status: {{$tcc->status()->get()->first()->descricao}}</p>
                    </div>
                    <div class="col-md-6">
                      <p class="text-muted">Semestre de início: {{$tcc->semestre_inicio}}</p>
                      <p class="text-muted">Ano de início: {{$tcc->ano_inicio}}</p>
                      <p class="text-muted">Abordagem: {{$tcc->abordagem()->get()->first()->descricao}}</p>
                      <p class="text-muted">Semestre de Defesa: {{$tcc->semestre_defesa == 1 ? "ATV29" : "ATV30"}}</p>
                      
                      <p class="text-muted">Área: {{$tcc->area()->get()->first()->descricao}}</p>
                    </div>
                    <div class="col-md-6">
                      <p class="text-muted">Natureza: {{$tcc->natureza()->get()->first()->descricao}}</p>
                      <p class="text-muted">Objetivo: {{$tcc->objetivo()->get()->first()->descricao}}</p>
                      <p class="text-muted">Procedimento: {{$tcc->procedimento()->get()->first()->descricao}}</p>
                      <p class="text-muted">Sub-área: {{$tcc->subarea()->get()->first()->descricao}}</p>
                      <p class="text-muted">Sisbin: {{$tcc->sisbin}}</p>
                      
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <p class="text-muted">Descrição: </p>
                      <p class="text-muted"> {{$tcc->resumo}}</p>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="col-md-6">
            <div class="box box-primary">
              <div class="box-header">
                <h3 class="box-title">Calendário de apresentação</h3>
              </div>
              <div class="box-body no-padding">
                <div class="google-calendar">
                  <iframe src="https://calendar.google.com/calendar/embed?src=548rvo9tv5peavk3gqc3gosd6o%40group.calendar.google.com&ctz=America%2FSao_Paulo" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  @stop
