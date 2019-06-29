
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gerenciamento de Projetos de Pesquisa</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/Ionicons/css/ionicons.min.css') }}">

    <!-- Select2 -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css">
    
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/vendor/adminlte/dist/css/AdminLTE.min.css')}}">

    <!-- DataTables -->
    <link rel="stylesheet" href="//cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css">
    
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('/vendor/adminlte/plugins/iCheck/square/blue.css')}}"></script>
    
    <link rel="stylesheet" href="{{ asset('/vendor/adminlte/dist/css/skins/skin-red.min.css')}} ">
        
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <meta name="google-site-verification" content="rXsxNrf-YuK-uYxeY2YcmSL15AJPC9UQBBwcvNZOwOw" />
</head>
<body class="hold-transition skin-red sidebar-mini">

    <div class="wrapper">
        <header class="main-header">
            <a href="http://localhost:8000/home" class="logo">
                <span class="logo-mini"><b>D</b>NP</span>
                <span class="logo-lg">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <div class="navbar-custom-menu">
                  <ul class="nav navbar-nav">
                    <li><a href="/login" title="Entrar"><i class="fa fa-users"></i></a>
                    </li>
                  </ul>
                </div>
              </nav>
        </header>
        <div class="content-wrapper" style="margin-left:0px">
            <section class="content">
              <div class="row">
                <div class="container">
                  <div class="py-5 text-center">
                    <img class="d-block mx-auto mb-4" src="{{asset('media/ufoplogo.jpg')}}" alt="" width="100">
                    <h2>Projetos de Iniciação Científica</h2>
                    <p class="lead">Projetos de Iniciação Científica cadastrados e ativos no Departamento de Engenharia de Produção no Instituto de Ciências Exatas e Aplicadas da Universidade Federal de Ouro Preto</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 order-md-1">
                    <hr class="mb-4">
                    <h4 class="mb-3">Filtros de Pesquisa</h4>

                    <form method="post" action="{{ route('exibir_resultados')}}">    
                      {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="form-group has-feedback {{ $errors->has('tipo_projeto_id') ? 'has-error' : '' }}">
                                    <label for="firstName">Tipo de projeto</label>
                                    <select class="form-control select2 " name="tipo_projeto_id" >
                                        <option value="">Selecione..</option>
                                        @foreach($tipoProjeto as $key => $tipo)
                                            <option value="{{$key}}"  {{ old("tipo_projeto_id") == $key ? "selected" : "" }}>{{$tipo}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('tipo_projeto_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('tipo_projeto_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                              <label for="firstName">Professor orientador ou coorientador</label>
                                <select class="form-control select2" name="professor_id" >
                                    <option value="">Selecione..</option>
                                    @foreach($professores as $professor)
                                      <option value="{{$professor->id}}" {{ old("professor_id") == $professor->id ? "selected" : "" }}>{{$professor->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="firstName">Status do projeto</label>
                                    <select class="form-control select2" name="status_id" >
                                      <option value="">Selecione..</option>
                                      @foreach($status as $singleStatus)
                                        <option value="{{$singleStatus->id}}"  {{ old("status_id") == $singleStatus->id ? "selected" : "" }} >{{$singleStatus->descricao}}</option>
                                      @endforeach
                                    </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="firstName">Área de conhecimento</label>
                                    <select class="form-control select2" name="area_id" >
                                      <option value="">Selecione..</option>
                                      @foreach($areas as $area)
                                        <option value="{{$area->id}}" {{ old("area_id") == $area->id ? "selected" : "" }}>{{$area->descricao}}</option>
                                      @endforeach
                                    </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="firstName">Abordagem de pesquisa</label>
                                <select class="form-control select2" name="abordagem_id" >
                                  <option value="">Selecione..</option>
                                  @foreach($abordagens as $abordagem)
                                    <option value="{{$abordagem->id}}" {{ old("abordagem_id") == $abordagem->id ? "selected" : "" }}>{{$abordagem->descricao}}</option>
                                  @endforeach    
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px">
                          <div class="col-md-4"></div>
                          
                            <div class="col-md-3">
                              <button type="submit" class="btn btn-block btn-primary btn-lg">Pesquisar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row" style="margin-top: 35px">
                @foreach($pesquisas as $pesquisa)
                  @if($loop->iteration % 5 == 0)
                      </div>
                      <div class="row" style="margin-top: 35px">
                  @endif
                      <div class="col-md-3">
                          <div class="box box-primary">
                            <div class="box-body box-profile">
                              <img class="profile-user-img img-responsive img-circle" src="{{ $pesquisa->orientador->profile_picture ? asset('storage/'.$pesquisa->orientador->profile_picture): '/media/mario.png' }}" alt="User profile picture">

                              <h3 class="profile-username text-center">{{$pesquisa->orientador->name ?? ""}}</h3>

                              <p class="text-muted text-center">{{$pesquisa->titulo ?? ""}}</p>

                              <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                   <b>Coorientador : </b>{{$pesquisa->coorientador->name ?? ""}}
                                </li>
                                <li class="list-group-item">
                                   <b>Status : </b>{{$pesquisa->status->descricao ?? ""}}
                                </li>
                                <li class="list-group-item">
                                  <b>Resumo : </b> {{$pesquisa->resumo ?? ""}}
                                </li>
                              </ul>

                              <a href="mailto:{{$pesquisa->orientador->email ?? ""}}" class="btn btn-primary btn-block"><b>Entrar em contato</b></a>
                            </div>
                          </div>
                      </div>
                @endforeach
            </div>
        </section>
    </div>
</div>
    <!-- ./wrapper -->

<script src="http://localhost:8000/vendor/adminlte/vendor/jquery/dist/jquery.min.js"></script>
<script src="http://localhost:8000/vendor/adminlte/vendor/jquery/dist/jquery.slimscroll.min.js"></script>
<script src="http://localhost:8000/vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Select2 -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <!-- DataTables -->
    <!-- <script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script> -->
    <script src="//cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.js"></script>

    <!-- ChartJS -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>

    <!-- iCheck -->
    <script src="http://localhost:8000/vendor/adminlte/plugins/iCheck/icheck.min.js"></script>

    <script src="http://localhost:8000/vendor/adminlte/dist/js/adminlte.min.js"></script>
    <script type="text/javascript">
        $('.select2').select2({
            width:'100%'
        });
    </script>   
</body>
</html>

