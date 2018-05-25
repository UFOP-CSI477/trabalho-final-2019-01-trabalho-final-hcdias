<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        
        <link rel="icon" href="{{ 'favicon.ico' }}">
            <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <!-- Bootstrap core CSS -->
        <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
        <link href="{{ asset('/vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- Custom styles for form validation -->
        <link href="{{ asset('css/form-validation.css') }}" rel="stylesheet">

        <!-- Custom styles for navbar -->
        <link href="{{ asset('css/navbar.css') }}" rel="stylesheet">

        <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Open+Sans:400,300'>
        <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/icon?family=Material+Icons'>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>

<!-- Navbar Component -->
<body>
    <div id='app'>
        @guest
            <!-- <nav class="navbar navbar-dark bg-dark"></nav> -->
        @else
            <nav class="navbar navbar-dark bg-dark">
                <a class="navbar-brand" href="">OPÇÕES DE CADASTRO</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbars01" aria-controls="navbars01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbars01">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Projetos de Iniciação Científica <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index_cad_orientacao.html">Trabalhos de Conclusão de Curso</a>
                        </li>
                    </ul>
                </div>
            </nav>
        @endguest
        @yield('content')
    </div>
    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2017-2018 Universidade Federal de Ouro Preto</p>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="#">Privacidade</a></li>
            <li class="list-inline-item"><a href="#">Termos</a></li>
            <li class="list-inline-item"><a href="#">Suporte</a></li>
        </ul>
    </footer>
    <!-- <script src="{{ asset('js/app.js') }}"></script> -->
    <script src="{{ asset('js/holder.min.js') }}"></script>
    <script>
    // Starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>

    @yield('scripts')
</body>