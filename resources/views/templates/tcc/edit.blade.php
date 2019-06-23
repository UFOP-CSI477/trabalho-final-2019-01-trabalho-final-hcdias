@extends('adminlte::page')
    @section('content')
    <!-- Content Header (Page header) -->
    <?php //dd($errors);?>
    <section class="content-header">
      <h1>
        Trabalho de conclusão de curso
        <small>editar trabalho</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Trabalho de conclusão de curso</a></li>
        <li class="active">Editar</li>
      </ol>
    </section>
    <section class="content">
        <form method="post" action="{{ route('atualizar_tcc',['id'=>$tcc->id])}}">
        {{ csrf_field() }}
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                          <h3 class="box-title">Docentes e discentes engajados</h3>
                        </div>
                         @if(Session::has('success'))
                            <div class="col-md-6 col-md-offset-3">
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4><i class="icon fa fa-check"></i> Sucesso</h4>
                                    {{ Session::get('success') }}
                              </div>
                            </div>
                        @endif
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
                                            @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('aluno'))
                                                @foreach($professores as $professor)
                                                    @if($professor->id == $tcc->orientador_id)
                                                        <option value="{{ $professor->id }}" selected="selected">{{ $professor->name }}</option>
                                                    @else
                                                        <option value="{{ $professor->id }}">{{ $professor->name }}</option>
                                                    @endif
                                                @endforeach
                                            @else
                                                @foreach($professores as $professor)
                                                    @if($professor->id == $tcc->orientador_id)
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
                                                @if($professor->id == $tcc->coorientador_id)
                                                    <option value="{{ $professor->id }}" selected="selected">{{ $professor->name }}</option>
                                                @else
                                                    <option value="{{ $professor->id }}">{{ $professor->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-feedback {{ $errors->has('discente') ? 'has-error' : '' }}">
                                        <label>Alunos envolvidos</label>
                                        <select id="discente" name="discente" class="form-control select2" 
                                         data-placeholder="">
                                         <option></option>
                                         @if(Auth::user()->hasRole('admin'))
                                            @foreach($alunos as $aluno)
                                                @if($tcc->aluno_id == $aluno->id)
                                                    <option selected="selected" value="{{$aluno->id}}">{{ $aluno->name }}</option>
                                                @else
                                                <option value="{{$aluno->id}}">{{ $aluno->name }}</option>
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach($alunos as $aluno)
                                                @if($aluno->id == $tcc->aluno_id)
                                                    <option selected="selected" value="{{$aluno->id}}">{{ $aluno->name }}</option>
                                                @endif
                                            @endforeach
                                        @endif
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
                          <h3 class="box-title">Dados sobre a tese</h3> 
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="titulo_tcc">Título</label>
                                    <div class="form-group has-feedback {{ $errors->has('titulo') ? 'has-error' : '' }}">
                                        <input type="text" class="form-control" name="titulo" id="titulo" placeholder="" value="{{$tcc->titulo}}">
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
                                                    @if ($semester == $tcc->semestre_inicio){
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
                                                    @if ($year == $tcc->ano_inicio)
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
                                                @if($item->id == $tcc->abordagem_id)
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
                                    <label>Semestre de defesa</label>
                                    <div class="form-group has-feedback {{ $errors->has('semestre_defesa') ? 'has-error' : '' }}">
                                        <select class="form-control" id="semestre_defesa" name="semestre_defesa">
                                            <option value="">Selecione</option>
                                            <option value="1" {{ $tcc->semestre_defesa == 1 ? "selected='selected'" : ""}}>ATV29</option>
                                            
                                            <option value="2" {{ $tcc->semestre_defesa == 2 ? "selected='selected'"  : ""}}>ATV30</option>
                                            
                                        </select>
                                        @if ($errors->has('semestre_defesa'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('semestre_defesa') }}</strong>
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
                                                @if($item->id == $tcc->area_id)
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
                                                @if($item->id == $tcc->natureza_id)
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
                                                @if($item->id == $tcc->objetivo_id)
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
                                                @if($item->id == $tcc->procedimentos_id)
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
                                                    @if($item->id == $tcc->sub_area_id)
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
                                <div class="col-md-6">
                                    <label>Link Sisbin</label>
                                    <div class="form-group has-feedback {{ $errors->has('sisbin') ? 'has-error' : '' }}">
                                        <input type='text' class="form-control" id="sisbin" name="sisbin" value="{{$tcc->sisbin}}">
                                            
                                        @if ($errors->has('sisbin'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('sisbin') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                    <label>Resumo do projeto</label>
                                    <textarea class="form-control" id="resumo" name="resumo" rows="5" placeholder="">{{$tcc->resumo}}
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
                                    @if($tcc->status_id == $statusItem->id)
                                        <div class='radio'>
                                            <label>
                                                <input type='radio' name='status'  value="{{$statusItem->id}}" checked='checked'> Trabalho {{$statusItem->descricao}}
                                            </label>
                                        </div>
                                    @else
                                        <div class='radio'>
                                            <label>
                                                <input type='radio' name='status'  value="{{$statusItem->id}}"> Trabalho {{$statusItem->descricao}}
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
                        </div>
                    </div>
                    <div class="box box-primary">
                        <div class="box-header">
                          <h3 class="box-title">Banca de apresentação</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Data de apresentação:</label>

                                        <div class="input-group date">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          <input type="text" class="form-control pull-right" id="banca_data" name="banca_data" value="{{ !is_null($tcc->banca_data) ? date('d/m/Y H:M',strtotime($tcc->banca_data)) : ""}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                        <label>Selecione 5 professores</label>
                                        <div class="form-group has-feedback {{ $errors->has('banca') ? 'has-error' : '' }}">
                                            <select id="banca" name="banca[]" class="form-control select2" 
                                         data-placeholder="Selecione um professor" multiple="multiple" 
                                         >
                                             <option></option>
                                            @foreach($professores as $professor)
                                                @if(in_array($professor->id,$professoresBanca))
                                                <option selected="selected" value="{{$professor->id}}">{{ $professor->name }}</option>
                                                @else
                                                <option value="{{$professor->id}}">{{ $professor->name }}</option>
                                                @endif
                                            @endforeach
                                            </select>
                                            @if ($errors->has('banca'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('banca') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    </div>
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
        $('.select2').select2();
        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"], input[type="radio"]').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass   : 'iradio_square-blue',
          increaseArea: '20%' 
        })
        $("#banca_data").daterangepicker({
                singleDatePicker:true,
                timePicker:true,
                timePicker24Hour:true,
                locale: {
                    format: 'DD/MM/YYYY H:mm '
                }
            });
    </script>
    @stop
