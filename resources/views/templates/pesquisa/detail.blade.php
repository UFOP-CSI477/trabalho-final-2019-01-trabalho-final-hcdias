@extends('adminlte::page')
	@section('content')
	<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Projetos de Pesquisa
        <small>detalhes do projeto e equipe de pesquisadores</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Projetos de Pesquisa</a></li>
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
                      <a href="#" class="users-list-name">{{$orientador->name}}</a>
                      <span class="users-list-date">Orientador</span>
                       <span class="users-list-date">{{ $orientador->email }}</span>
                    </li>  
                  
                    <li style="width:30%">
                      <img src="{{ $coorientador->profile_picture ? asset('storage/'.$coorientador->profile_picture) : '/media/mario.png'}}">
                      <a href="#" class="users-list-name">{{$coorientador->name}}</a>
                      <span class="users-list-date">Coorientador</span>
                       <span class="users-list-date">{{ $coorientador->email }}</span>
                    </li>
                </ul>
                <ul class="users-list clearfix">
                  @foreach($alunos as $aluno)
                      <li style="width:30%;">
                        <img src="{{ $aluno->profile_picture ? asset('storage/'.$aluno->profile_picture) : '/media/mario.png'}}">
                        <a href="#" class="users-list-name">{{$aluno->name}}</a>
                        <span class="users-list-date">Orientando</span>
                        <span class="users-list-date">{{$aluno->email}}</span>
                      </li> 
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
        
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Detalhes do projeto </h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-6">
                  <p class="lead text-muted"> Título: {{$pesquisa->titulo}}</p>
                </div>
                <div class="col-md-6">
                  <p class="lead text-status-{{$pesquisa->status()->get()->first()->id}}">Status: {{$pesquisa->status()->get()->first()->descricao}}</p>
                </div>
                <div class="col-md-6">
                  <p class="text-muted">Semestre de início: {{$pesquisa->semestre_inicio}}</p>
                  <p class="text-muted">Ano de início: {{$pesquisa->ano_inicio}}</p>
                  <p class="text-muted">Abordagem: {{$pesquisa->abordagem()->get()->first()->descricao}}</p>
                  <p class="text-muted">Agência: {{$pesquisa->agencia()->get()->first()->descricao}}</p>
                  <p class="text-muted">Área: {{$pesquisa->area()->get()->first()->descricao}}</p>
                </div>
                <div class="col-md-6">
                  <p class="text-muted">Natureza: {{$pesquisa->natureza()->get()->first()->descricao}}</p>
                  <p class="text-muted">Objetivo: {{$pesquisa->objetivo()->get()->first()->descricao}}</p>
                  <p class="text-muted">Procedimento: {{$pesquisa->procedimento()->get()->first()->descricao}}</p>
                  <p class="text-muted">Sub-área: {{$pesquisa->subarea()->get()->first()->descricao}}</p>
                  
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <p class="text-muted">Descrição: </p>
                  <p class="text-muted"> {{$pesquisa->resumo}}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  @stop