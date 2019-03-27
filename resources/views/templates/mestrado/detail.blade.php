@extends('adminlte::page')
	@section('content')
	<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Teses de mestrado
        <small>detalhes do mestrado</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Mestrados</a></li>
        <li class="active">detalhes</li>
      </ol>
    </section>
    <div class="row">
      <section class="content col-lg-12 connectedSortable ui-sortable">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Integrantes</h3>
            </div>
            <div class="box-body no-padding">
                <ul class="users-list clearfix">
                    <li>
                      <img src="/media/mario.png">
                      <a href="#" class="users-list-name">{{$orientador->nome}}</a>
                      <span class="users-list-date">Orientador</span>
                       <span class="users-list-date">{{ $orientador->email }}</span>
                    </li>  
                    <li>
                      <img src="/media/mario.png">
                      <a href="#" class="users-list-name">{{$coorientador->nome}}</a>
                      <span class="users-list-date">Coorientador</span>
                       <span class="users-list-date">{{ $coorientador->email }}</span>
                    </li>  
                 
                    <li>
                      <img src="/media/mario2.png">
                      <a href="#" class="users-list-name">{{$aluno->nome}}</a>
                      <span class="users-list-date">Orientando</span>
                      <span class="users-list-date">Matricula {{$aluno->matricula}}</span>
                    </li> 
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
                  <p class="lead text-muted"> Título: {{$mestrado->titulo_mestrado}}</p>
                </div>
                <div class="col-md-6">
                  <p class="lead text-status-{{$mestrado->status()->get()->first()->id}}">Status: {{$mestrado->status()->get()->first()->descricao}}</p>
                </div>
                <div class="col-md-6">
                  <p class="text-muted">Semestre de início: {{$mestrado->semestre_inicio_mestrado}}</p>
                  <p class="text-muted">Ano de início: {{$mestrado->ano_inicio_mestrado}}</p>
                  <p class="text-muted">Abordagem: {{$mestrado->abordagem()->get()->first()->descricao}}</p>
                  
                  <p class="text-muted">Área: {{$mestrado->area()->get()->first()->descricao}}</p>
                </div>
                <div class="col-md-6">
                  <p class="text-muted">Natureza: {{$mestrado->natureza()->get()->first()->descricao}}</p>
                  <p class="text-muted">Objetivo: {{$mestrado->objetivo()->get()->first()->descricao}}</p>
                  <p class="text-muted">Procedimento: {{$mestrado->procedimento()->get()->first()->descricao}}</p>
                  <p class="text-muted">Sub-área: {{$mestrado->subarea()->get()->first()->descricao}}</p>
                  <p class="text-muted">Sisbin: {{$mestrado->sisbin_mestrado}}</p>
                  
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <p class="text-muted">Descrição: </p>
                  <p class="text-muted"> {{$mestrado->resumo_mestrado}}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  @stop
