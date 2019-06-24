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
                  <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" id="previewPicture" src="{{ $user->profile_picture ? asset('storage/'.$user->profile_picture) : '/media/mario.png'}}" alt="User profile picture" style="cursor:pointer" title="Clique para alterar a foto">
                    <small>Tamanho recomendado:128x128</small>

                    <h3 class="profile-username text-center">{{$user->name}}</h3>

                    <p class="text-muted text-center">{{$user->group->descricao}}</p>
                    <form method='post' action="{{ route('salvar_perfil') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="file" name='profilePicture' id='profilePicture' style="display: none">
                        <div class="row">
                          <div class="col-md-12">
                            <button type='submit' class="btn btn-primary btn-block">Alterar foto de perfil</button>
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