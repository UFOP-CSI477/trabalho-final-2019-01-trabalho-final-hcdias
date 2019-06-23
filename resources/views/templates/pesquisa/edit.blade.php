@extends('adminlte::page')
    @section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Projetos de Pesquisa
        <small>editar projeto de pesquisa</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Projetos de Pesquisa</a></li>
        <li class="active">Editar</li>
      </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                @if(Session::has('success'))
                    <div class="col-md-6 col-md-offset-3">
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-check"></i> Sucesso</h4>
                            {{ Session::get('success') }}
                      </div>
                    </div>
                @endif
            </div>
            <div class="col-md-2">
            </div>
        </div>
        <form method="post" action="{{ route('atualizar_pesquisa',['id'=>$pesquisa->id])}}">
        {{ csrf_field() }}
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                          <h3 class="box-title">Docentes e discentes engajados</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Professor orientador</label>
                                    <div class="form-group has-feedback {{ $errors->has('orientador') ? 'has-error' : '' }}">
                                        <select id="orientador" name="orientador" class="form-control select2" 
                                         data-placeholder="Selecione um professor" 
                                         >
                                            <option></option>
                                            @if(Auth::user()->hasRole('admin'))
                                                @foreach($professores as $professor)
                                                    @if($pesquisa->orientador_id == $professor->id)
                                                        <option value="{{ $professor->id }}" selected="selected">{{ $professor->name }}</option>
                                                    @else
                                                        <option value="{{ $professor->id }}">{{ $professor->name }}</option>
                                                    @endif
                                                @endforeach
                                            @else
                                                @foreach($professores as $professor)
                                                    @if($pesquisa->orientador_id == $professor->id)
                                                        <option value="{{ $professor->id }}" selected="selected">{{ $professor->name }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->has('orientador'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('orientador') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Professor coorientador</label>
                                        <select id="coorientador" name="coorientador" class="form-control select2" 
                                        data-placeholder="Selecione um professor" >
                                            <option></option>
                                                @foreach($professores as $professor)
                                                    @if($pesquisa->coorientador_id == $professor->id)
                                                        <option value="{{ $professor->id }}" selected="selected">{{ $professor->name }}</option>
                                                    @else
                                                        <option value="{{ $professor->id }}">{{ $professor->name }}</option>
                                                    @endif
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback {{ $errors->has('discentes') ? 'has-error' : '' }}">
                                        <label>Alunos envolvidos</label>
                                        <select id="discentes" name="discentes[]" class="form-control select2" 
                                         data-placeholder="" multiple="multiple" 
                                         >
                                         <option></option>
                                            @foreach($alunosPesquisa as $alunoPesquisa)
                                                <option value="{{ $alunoPesquisa->id }}" selected="selected">{{ $alunoPesquisa->name }}</option>
                                            @endforeach
                                            @foreach($alunos as $aluno)
                                                <option value="{{ $aluno->id }}" >{{ $aluno->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('discentes'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('discentes') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header">
                          <h3 class="box-title">Dados sobre o projeto</h3> 
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="titulo">Título</label>
                                    <div class="form-group has-feedback {{ $errors->has('titulo') ? 'has-error' : '' }}">
                                        <input type="text" class="form-control" name="titulo" id="titulo" placeholder="" value="{{$pesquisa->titulo}}">
                                        @if ($errors->has('titulo'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('titulo') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label>Semestre de início</label>
                                    <div class="form-group has-feedback {{ $errors->has('semestre_inicio') ? 'has-error' : '' }}">
                                        <select class="form-control" id="semestre_inicio" name="semestre_inicio">
                                            <option value="">Selecione</option>
                                                @for($semester = 1; $semester < 3; $semester++)
                                                    @if ($semester == $pesquisa->semestre_inicio){
                                                        <option value="{{$semester}}" selected = 'selected'>{{$semester}}º semestre</option>";
                                                    @else
                                                        <option value="{{$semester}}">{{$semester}}º semestre</option>";
                                                    @endif
                                                @endfor
                                        </select>
                                        @if ($errors->has('semestre_inicio'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('semestre_inicio') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Ano de início</label>
                                    <div class="form-group has-feedback {{ $errors->has('ano_inicio') ? 'has-error' : '' }}">
                                        <select class="form-control" id="ano_inicio" name="ano_inicio">
                                            <option value="">Selecione</option>
                                                @for ($year = 2010; $year < 2022; $year++)
                                                    @if ($year == $pesquisa->ano_inicio)
                                                        <option value="{{$year}}" selected = 'selected'>{{$year}}</option>
                                                    @else
                                                        <option value="{{$year}}"> {{$year}} </option>
                                                    @endif
                                                @endfor
                                        </select>
                                        @if ($errors->has('ano_inicio'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('ano_inicio') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Abordagem</label>
                                    <div class="form-group has-feedback {{ $errors->has('abordagem') ? 'has-error' : '' }}">
                                        <select class="form-control" id="abordagem" name="abordagem">
                                            <option value="">Selecione</option>
                                            @foreach($abordagem as $item)
                                                @if($item->id == $pesquisa->abordagem_id)
                                                    <option value="{{$item->id}}" selected="selected">{{$item->descricao}}</option>
                                                @else
                                                    <option value="{{$item->id}}">{{$item->descricao}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('abordagem'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('abordagem') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Agência</label>
                                    <div class="form-group has-feedback {{ $errors->has('agencia') ? 'has-error' : '' }}">
                                        <select class="form-control" id="agencia" name="agencia">
                                            <option value="">Selecione</option>
                                            @foreach($agencia as $item)
                                                @if($item->id == $pesquisa->agencia_id)
                                                    <option value="{{$item->id}}" selected="selected">{{$item->descricao}}</option>
                                                @else
                                                    <option value="{{$item->id}}">{{$item->descricao}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('agencia'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('agencia') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label>Area</label>
                                    <div class="form-group has-feedback {{ $errors->has('area') ? 'has-error' : '' }}">
                                        <select class="form-control" id="area" name="area">
                                            <option value="">Selecione</option>
                                            @foreach($area as $item)
                                                @if($item->id == $pesquisa->area_id)
                                                    <option value="{{$item->id}}" selected="selected">{{$item->descricao}}</option>
                                                @else
                                                    <option value="{{$item->id}}">{{$item->descricao}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('area'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('area') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label>Natureza</label>
                                    <div class="form-group has-feedback {{ $errors->has('natureza') ? 'has-error' : '' }}">
                                        <select class="form-control" id="natureza" name="natureza">
                                            <option value="">Selecione</option>
                                            @foreach($natureza as $item)
                                                @if($item->id == $pesquisa->natureza_id)
                                                    <option value="{{$item->id}}" selected="selected">{{$item->descricao}}</option>
                                                @else
                                                    <option value="{{$item->id}}">{{$item->descricao}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('natureza'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('natureza') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Objetivo</label>
                                    <div class="form-group has-feedback {{ $errors->has('objetivo') ? 'has-error' : '' }}">
                                        <select class="form-control" id="objetivo" name="objetivo">
                                            <option value="">Selecione</option>
                                            @foreach($objetivo as $item)
                                                @if($item->id == $pesquisa->objetivo_id)
                                                    <option value="{{$item->id}}" selected="selected">{{$item->descricao}}</option>
                                                @else
                                                    <option value="{{$item->id}}">{{$item->descricao}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('objetivo'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('objetivo') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Procedimento</label>
                                    <div class="form-group has-feedback {{ $errors->has('procedimento') ? 'has-error' : '' }}">
                                        <select class="form-control" id="procedimento" name="procedimento">
                                            <option value="">Selecione</option>
                                            @foreach($procedimento as $item)
                                                @if($item->id == $pesquisa->procedimentos_id)
                                                    <option value="{{$item->id}}" selected="selected">{{$item->descricao}}</option>
                                                @else
                                                    <option value="{{$item->id}}">{{$item->descricao}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('procedimento'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('procedimento') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Sub-área</label>
                                    <div class="form-group has-feedback {{ $errors->has('subarea') ? 'has-error' : '' }}">
                                        <select class="form-control" id="subarea" name="subarea">
                                            <option value="">Selecione</option>
                                                @foreach($subarea as $item)
                                                    @if($item->id == $pesquisa->sub_area_id)
                                                        <option value="{{$item->id}}" selected="selected">{{$item->descricao}}</option>
                                                    @else
                                                        <option value="{{$item->id}}">{{$item->descricao}}</option>
                                                    @endif
                                                @endforeach
                                        </select>
                                        @if ($errors->has('subarea'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('subarea') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                    <label>Resumo do projeto</label>
                                    <textarea class="form-control" id="resumo" name="resumo" rows="5" placeholder="">
                                            {{$pesquisa->resumo}}
                                    </textarea>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header">
                          <h3 class="box-title">Status do projeto</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                @foreach($status as $statusItem)
                                    @if($pesquisa->status_id == $statusItem->id)
                                        <div class='radio'>
                                            <label>
                                                <input type='radio' name='status'  value="{{$statusItem->id}}" checked='checked'> Projeto {{$statusItem->descricao}}
                                            </label>
                                        </div>
                                    @else
                                        <div class='radio'>
                                            <label>
                                                <input type='radio' name='status'  value="{{$statusItem->id}}"> Projeto {{$statusItem->descricao}}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                      <input type="checkbox">
                                      Ocultar em consultas realizadas por usuários não cadastrados
                                    </label>
                                  </div>
                            </div>
                            <div class="row" style='margin-top: 65px'>
                                <div class="form-group">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-block btn-primary btn-lg">Confirmar cadastro</button>
                                    </div>
                                </div>
                            </div>  
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
    @stop
    @section('js')
    <script type="text/javascript">
        $('.select2').select2({
            width:'100%'
        });
        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"], input[type="radio"]').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass   : 'iradio_square-blue',
          increaseArea: '20%' 
        })
    </script>
    @stop
