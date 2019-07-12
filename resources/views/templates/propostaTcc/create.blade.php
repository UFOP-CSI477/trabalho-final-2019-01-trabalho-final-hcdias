@extends('adminlte::page')
    @section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Proposta de TCC
        <small>criar nova proposta</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Proposta de TCC</a></li>
        <li class="active">Nova proposta</li>
      </ol>
    </section>
    <section class="content">
        <form method="post" action="{{ route('salvar_proposta_tcc')}}">
            {{ csrf_field() }}
            {{ method_field('POST') }}
            <input type="hidden" name="orientador_id" id="professor-selected" value="">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                          <h3 class="box-title">Dados sobre a proposta</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group has-feedback {{ $errors->has('titulo') ? 'has-error' : '' }}">
                                        <label for="titulo">Título</label>
                                        <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Título do trabalho">
                                        @if ($errors->has('titulo'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('titulo') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group has-feedback {{$errors->has('descricao') ? 'has-error' : ''}}">
                                        <label>Resumo do projeto</label>
                                        <textarea class="form-control" id="descricao" name="descricao" rows="5" placeholder="Resumo do projeto"></textarea>
                                        @if ($errors->has('descricao'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('descricao') }}</strong>
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
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                          <h3 class="box-title">Orientadores</h3>
                        </div>
                            <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Selecione sua área de interesse</label>
                                    <div class="form-group has-feedback {{$errors->has('area_id') ? 'has-error' : ''}}">
                                        <select id="area-interesse" name="area_id" class="form-control select2" 
                                         data-placeholder="Selecione uma área de interesse" 
                                         >
                                         <option></option>
                                            @foreach($areas as $area)
                                                <option value="{{$area->id}}">{{ $area->descricao }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('area_id'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('area_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="professor-container">
                                <div class="col-md-12">
                                    @if ($errors->has('orientador_id'))
                                        <div class="alert alert-danger alert-dismissible" id="info-professor">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <h4><i class="icon fa fa-ban"></i>Atenção </h4>
                                            Nenhum professor selecionado
                                        </div>
                                    @else
                                        <div class="alert alert-info alert-dismissible" id="info-professor">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <h4><i class="icon fa fa-info"></i>Atenção </h4>
                                            Nenhum professor selecionado
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3" style='margin-top: 65px'>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-block btn-primary btn-lg">Confirmar cadastro</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
              
            </div>
        </form>
    </section>
    @stop
    @section('js')
        <script type="text/javascript">
            $('.select2').select2({
                width:'100%'
            });

            $("#area-interesse").on('change',function(){
                let id = $(this).val();
                $.ajax({
                    url:'/proposta-tcc/area-interesse-professor/'+id,
                    type:'GET',
                    dataType:'json',
                    headers:{
                        'X-CSRF-Token':'{{ csrf_token() }}'
                    },
                    beforeSend:function(){
                        console.log('sending..');
                    }
                })
                .done(function(data){
                    if(!data.length > 0 ){
                        let alert = '<div class="col-md-12">\
                                <div class="alert alert-info alert-dismissible" id="info-professor">\
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>\
                                    <h4><i class="icon fa fa-info"></i> Atenção</h4>\
                                    Nenhum professor encontrado\
                                </div></div>';

                        $("#professor-container").html(alert);
                    }else{
                        let html = '<div class="col-md-2">\
                                    <img class="profile-user-img img-responsive img-circle" id="previewPicture" src="@picture" alt="User profile picture" style="cursor:pointer" title="Clique para selecionar" data-professor-id="@id">\
                                        <p class="text-center check-professor" style="display:none"><i class="icon fa fa-check"></i></p>\
                                        <h3 class="profile-username text-center" title="@name">@name</h3>\
                                        <p class="text-muted text-center" title="@name"></p>\
                                    </div>';
                        let profiles ='';
                        for(item in data){
                            let picture = data[item].profile_picture ? '/storage/'+data[item].profile_picture : '/media/mario.png';
                            profiles += html.replace(/@picture/,picture)
                            .replace(/@name/g,data[item].name)
                            .replace(/@id/,data[item].id);
                        }

                        $("#professor-container").html(profiles);

                        $(".profile-user-img").click(function(){
                            let id = $(this).data('professor-id');
                            $(".check-professor").css('display','none');
                            $(this).next('p').css('display','block');
                            $("#professor-selected").val(id);
                        });                        
                    }
                })
                .fail(function(jqXHR,textStatus){
                    let alert = '<div class="col-md-12">\
                            <div class="alert alert-danger alert-dismissible">\
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>\
                                <h4><i class="icon fa fa-ban"></i> Erro</h4>\
                                Houve um erro ao buscar os dados. Tente mais tarde.\
                            </div></div>';

                    $("#professor-container").html(alert);
                });  
            });

        </script>
    @stop