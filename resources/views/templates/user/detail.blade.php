@extends('adminlte::page')
  @section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Perfil de usuário
        <small>Gerenciar perfil</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6" style="text-align: center">
                <div class="box box-primary">
                  <div class="box-header">
                    <h3 class="box-title">Seus dados</h3>
                  </div>
                  @if(Session::has('success'))
                      <div class="col-md-12">
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
                  <div class="box-body">
                    <img class="profile-user-img img-responsive img-circle" id="previewPicture" src="{{ $user->profile_picture ? asset('storage/'.$user->profile_picture) : '/media/mario.png'}}" alt="User profile picture" style="cursor:pointer" title="Clique para alterar a foto">
                    <small>Tamanho recomendado:128x128</small>

                    <h3 class="profile-username text-center">{{$user->name}}</h3>

                    <p class="text-muted text-center">{{$user->group->descricao}}</p>
                    <form method='post' action="{{ route('salvar_perfil') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="file" name='profilePicture' id='profilePicture' style="display: none">
                          @can('professor')
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label>Áreas de atuação</label>
                                  <select class="form-control select2" multiple="multiple" name="atuacao[]" id="atuacao" data-placeholder="Selecione as áreas de atuação">
                                    @foreach($areas as $area)
                                      @if($user->areaInteresse->contains($area->id))
                                        <option value="{{ $area->id }}" selected="selected">{{$area->descricao}}</option>
                                      @else
                                        <option value="{{ $area->id }}">{{$area->descricao}}</option>
                                      @endif
                                    @endforeach
                                  </select> 
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label>Descreva brevemente seus interesses:</label>
                                  <textarea class="form-control" name="interesse" rows="5" placeholder="Resumo dos interesses">
                                    {{$user->area_interesse}}</textarea>
                                </div>
                              </div>                              
                            </div>
                          @endcan
                        <div class="row">
                          <div class="col-md-12">
                            <button type='submit' class="btn btn-primary btn-block">Alterar perfil</button>
                          </div>
                        </div>
                    </form>
                  </div>
                </div>
            </div>
        </div>
    </section>
  @stop  
  @section('js')
      <script type="text/javascript">
          $('.select2').select2({
            width:'100%'
          });
        $("#profilePicture").on('change',function(){
          readURL(this);
        });

        $("#previewPicture").click(function(){
          $("#profilePicture").click();
        })

        function readURL(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              
              reader.onload = function (e) {
                  $('#previewPicture').attr('src', e.target.result);
              }
              
              reader.readAsDataURL(input.files[0]);
          }
        }
    </script>
  @stop