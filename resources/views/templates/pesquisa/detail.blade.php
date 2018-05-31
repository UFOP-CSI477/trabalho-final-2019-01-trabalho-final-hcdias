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
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Integrantes</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-3 col-md-offset-3">
                  <div class="box box-primary">
                    <div class="box-body box-profile">
                      <img class="profile-user-img img-responsive img-circle" src="/media/mario.png" alt="User profile picture">
                      <h3 class="profile-username text-center">Mario</h3>
                      <p class="text-muted text-center">Orientador</p>
                      <p class="text-muted text-center">mario@mario.com.br</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="box box-primary">
                    <div class="box-body box-profile">
                      <img class="profile-user-img img-responsive img-circle" src="/media/mario.png" alt="User profile picture">
                      <h3 class="profile-username text-center">Mario</h3>
                      <p class="text-muted text-center">Coorientador</p>
                      <p class="text-muted text-center">mario@mario.com.br</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Detalhes do projeto</h3>
            </div>
            <div class="box-body">
              
            </div>
          </div>
        </div>
      </div>
    </section>
  @stop