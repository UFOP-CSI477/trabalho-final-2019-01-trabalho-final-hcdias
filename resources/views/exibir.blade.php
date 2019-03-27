
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gerenciamento de Projetos de Pesquisa</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="http://localhost:8000/vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="http://localhost:8000/vendor/adminlte/vendor/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="http://localhost:8000/vendor/adminlte/vendor/Ionicons/css/ionicons.min.css">

            <!-- Select2 -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css">
    
    <!-- Theme style -->
    <link rel="stylesheet" href="http://localhost:8000/vendor/adminlte/dist/css/AdminLTE.min.css">

            <!-- DataTables -->
        <link rel="stylesheet" href="//cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css">
        <!-- <link rel="stylesheet" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css"> -->
    
            <!-- iCheck -->
        <link rel="stylesheet" href="http://localhost:8000/vendor/adminlte/plugins/iCheck/square/blue.css"></script>
    
        <link rel="stylesheet"
          href="http://localhost:8000/vendor/adminlte/dist/css/skins/skin-red.min.css ">
        
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-red sidebar-mini ">

    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">
                        <!-- Logo -->
            <a href="http://localhost:8000/home" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>D</b>NP</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>UFOP</b>-DEENP</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <!-- <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"> -->
                    <!-- <span class="sr-only">Toggle navigation</span> -->
                <!-- </a> -->
                            <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">

                    <!-- <ul class="nav navbar-nav">
                        <li>
                                                            <a href="#"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                >
                                    <i class="fa fa-fw fa-power-off"></i> Log Out
                                </a>
                                <form id="logout-form" action="http://localhost:8000/logout" method="POST" style="display: none;">
                                                                        <input type="hidden" name="_token" value="Q3QFjqKlv833CokbSsZEK4JfPvn58lzyOEPy9NHc">
                                </form>
                                                    </li>
                    </ul> -->
                </div>
                            </nav>
        </header>
        <div class="content-wrapper" style="margin-left:0px">
            
            <!-- Content Header (Page header) -->
            <!-- <section class="content-header">
                    <h1>Bem vindo, admin</h1>
    <small>Acopanhe sua movimentação recente de projetos</small>
            </section> -->

            <!-- Main content -->
            <section class="content">
              <div class="row">
                <div class="container">
                  <div class="py-5 text-center">
                    <img class="d-block mx-auto mb-4" src="http://www.sisbin.ufop.br/evento/images/ufop.gif" alt="" width="100">
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
              <label for="firstName">Professor orientador</label>
                <select class="form-control" name="professor_id" required>
                    <option value="">Todos...</option>
                    @foreach($professores as $professor)
                      <option value="{{$professor->id}}">{{$professor["nome"]}}</option>
                    @endforeach
                </select>
              <div class="invalid-feedback">
                  Favor informar professor válido.
            </div>
            </div>
    
      

          <div class="col-md-3 mb-3">
              <label for="firstName">Status do projeto</label>
                <select class="form-control" name="status_id" required>
                  <option value="">Todos...</option>
                  @foreach($status as $estado)
                    <option value="{{$estado->id}}">{{$estado["descricao"]}}</option>
                  @endforeach
                </select>
              <div class="invalid-feedback">
                  Favor informar status válido.
            </div>
            </div>
            
          <div class="col-md-3 mb-3">
              <label for="firstName">Área de conhecimento</label>
                <select class="form-control" name="areaPesquisa_id" required>
                  <option value="">Todos...</option>
                  @foreach($areasPesquisa as $areas)
                    <option value="{{$areas->id}}">{{$areas["descricao"]}}</option>
                  @endforeach
                </select>
              <div class="invalid-feedback">
                  Favor informar área válida.
            </div>
            </div>
            
          <div class="col-md-3 mb-3">
              <label for="firstName">Abordagem de pesquisa</label>
                <select class="form-control" name="abordagem_id" required>
                  <option value="">Todos...</option>
                  @foreach($abordagens as $abordagem)
                    <option value="{{$abordagem->id}}">{{$abordagem["descricao"]}}</option>
                  @endforeach    
                </select>
              <div class="invalid-feedback">
                  Favor informar abordagem válida.
            </div>
            </div>

      </div>
      <button type="submit" class="btn btn-block btn-primary btn-lg">Pesquisar</button>
      </form>
              </div>

</div>
            <div class="row" style="margin-top: 35px">
              @foreach($pesquisas as $pesquisa)
              <div class="col-md-3">
          <div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-text-gear"></i>

              <h3 class="box-title">{{$pesquisa["pesquisa_titulo"]}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <dl class="dl-horizontal">
                <dt>
                      <img src="/media/mario.png">
                    
                    
                </dt>
                <dd>{{$pesquisa["pesquisa_resumo"]}}</dd>
                
                <dt>Contato</dt>
                <dd>Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo
                  sit amet risus.
                </dd>
              </dl>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      @endforeach

            </div>

            </section>
            <!-- /.content -->
                    </div>
        <!-- /.content-wrapper -->

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
        
</body>
</html>

