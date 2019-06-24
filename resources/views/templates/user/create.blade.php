@extends('adminlte::page')
    @section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Gerência de usuários
        <small>criar novo usuário</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Gerência de usuários</a></li>
        <li class="active">Novo</li>
      </ol>
    </section>
    <section class="content">
        <form method="post" action="{{ route('salvar_usuario')}}">
        {{ csrf_field() }}
            <div class="row">
                <div class="col-md-8">
                    <div class="box box-primary">
                        <div class="box-header">
                          <h3 class="box-title">Dados do usuário</h3>
                        </div>
                        @if(Session::has('success'))
                            <div class="col-md-6 col-md-offset-3">
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4><i class="icon fa fa-check"></i> Sucesso</h4>
                                    {{ Session::get('success') }}
                              </div>
                            </div>
                        @elseif(Session::has('error'))
                            <div class="col-md-6 col-md-offset-3">
                                <div class="alert alert-error alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4><i class="icon fa fa-check"></i> Erro</h4>
                                    {{ Session::get('error') }}
                              </div>
                            </div>
                        @endif
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group has-feedback {{ $errors->has('cpf') ? 'has-error' : '' }}">
                                        <label>CPF do usuário</label>
                                        <input type="text" name="cpf" id="cpf" class="form-control" value="{{ old('cpf') }}"
                                               placeholder="Ex: 10000058901">
                                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                        @if ($errors->has('cpf'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('cpf') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label>&nbsp;</label>
                                    <div class="form-group">
                                        <div class="btn-group">
                                            <button type="button" id="cpfSearch" class="btn btn-primary">Buscar</button>
                                            <button type="button" id="load_select" class="btn btn-info">
                                                <i class="fa fa-refresh"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}" placeholder="nome do usuário" readonly="true">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="useremail" id="useremail" class="form-control" value="{{ old('useremail') }}" placeholder="email do usuário" readonly="true">
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group has-feedback {{ $errors->has('papel') ? 'has-error' : '' }}">
                                        <label>Permissão adicional</label>
                                        <select id="papel" name="papel" class="form-control select2" 
                                         data-placeholder="Selecione o papel do usuário" 
                                         >
                                         <option></option>
                                        @foreach($papeis as $papel)
                                            <option value="{{$papel->id}}" title="{{ $papel->description }}">{{ $papel->name }}</option>
                                        @endforeach
                                        </select>
                                        @if ($errors->has('papel'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('papel') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary btn-block">Adicionar Usuário</button>
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
        $('input[type="radio"]').iCheck({
          radioClass   : 'iradio_square-blue'
        });

        $('#cpfSearch').on('click',function(event){
            var value = $("#cpf").val();
            if(! value ){ return; }

            var url = '/usuario/vinculo-usuario/'+value;
            $.ajax({
                url:url,
                type:'GET',
                dataType:'json',
                headers:{
                    'X-CSRF-Token':'{{ csrf_token() }}'
                },
                beforeSend:function(){
                    $('#load_select').removeClass();
                    $('#load_select > i').removeClass();
                    $('#load_select').addClass("btn btn-info");
                    $('#load_select > i').addClass('fa fa-refresh fa-spin');
                }
            })
            .done(function(data){
                $('#load_select').removeClass();
                $('#load_select > i').removeClass();

                if(data == ""){
                    $('#load_select').addClass('btn btn-warning');
                    $('#load_select > i').addClass('fa fa-exclamation-triangle');
                }else{
                    $("#username").val(data.nomecompleto);
                    $("#useremail").val(data.email);

                    $('#load_select > i').addClass('fa fa-check');
                    $('#load_select').addClass('btn btn-success');

                }
            })
            .fail(function(jqXHR,textStatus){

            });  
        });
    </script>
    @stop