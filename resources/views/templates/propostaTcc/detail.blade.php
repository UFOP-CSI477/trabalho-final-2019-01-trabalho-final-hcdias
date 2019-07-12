@extends('adminlte::page')
    @section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Proposta de TCC
        <small>detalhes da proposta</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Proposta de TCC</a></li>
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
                        <img src="{{ $proposta->orientador->profile_picture ? asset('storage/'.$proposta->orientador->profile_picture) : '/media/mario.png'}}">
                        <a href="#" class="users-list-name">{{$proposta->orientador->name}}</a>
                        <span class="users-list-date">Orientador</span>
                         <span class="users-list-date">{{ $proposta->orientador->email }}</span>
                      </li>  
                      
                      <li style="width:30%">
                        <img src="{{ $proposta->aluno->profile_picture ? asset('storage/'.$proposta->aluno->profile_picture) : '/media/mario.png'}}">
                        <a href="#" class="users-list-name">{{$proposta->aluno->name}}</a>
                        <span class="users-list-date">Orientando</span>
                        <span class="users-list-date">{{$proposta->aluno->email}}</span>
                      </li> 
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-md-6">
                <div class="box box-primary">
                  <div class="box-header">
                    <h3 class="box-title">Detalhes da proposta </h3>
                  </div>
                  <div class="box-body">
                    <div class="row">
                      <div class="col-md-6">
                        <p class="lead text-muted"> Título: {{$proposta->titulo}}</p>
                      </div>
                      <div class="col-md-6">
                        <p class="lead text-status-{{$proposta->status()->get()->first()->id}}">Status: {{$proposta->status()->get()->first()->descricao}}</p>
                      </div>
                      <div class="col-md-6">
                        <p class="text-muted">Área: {{$proposta->area()->get()->first()->descricao}}</p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <p class="text-muted">Descrição: </p>
                        <p class="text-muted"> {{$proposta->descricao}}</p>
                      </div>
                    </div>
                  </div>
                </div>
            </div>           
        </div>
        @can('professor')
        <div class="row">
          <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title">Alterar proposta </h3>
                </div>
                <div class="box-body">
                  <div class="row">
                    <form method='post' action="{{ route('atualizar_proposta_professor',['id'=>$proposta]) }}">
                        {{ csrf_field() }}
                        <div class="col-md-6">
                          <label>Status</label>
                          <div class="form-group has-feedback {{$errors->has('status_id') ? 'has-error' : ''}}">
                              <select id="status" name="status_id" class="form-control select2" 
                               data-placeholder="Selecione um status" 
                               >
                               <option></option>
                                  @foreach($status as $stats)
                                    @if($stats->id == $proposta->status->id)
                                      <option value="{{$stats->id}}" selected="selected">{{ $stats->descricao }}</option>
                                    @else
                                    <option value="{{$stats->id}}" >{{ $stats->descricao }}</option>
                                    @endif
                                  @endforeach
                              </select>
                              @if ($errors->has('status_id'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('status_id') }}</strong>
                                  </span>
                              @endif
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-6 col-md-offset-3" style='margin-top: 65px'>
                              <div class="text-center">
                                  <button type="submit" class="btn btn-block btn-primary btn-lg">Confirmar alteração</button>
                              </div>
                          </div>
                      </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endcan
      </section>
    </div>
  @stop
