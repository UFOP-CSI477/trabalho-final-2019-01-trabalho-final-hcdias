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

        <title>Projetos de Pesquisa</title>

        <!-- Bootstrap core CSS -->
        <link href="{{ asset('/vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- Custom styles for form validation -->
        <link href="{{ asset('css/form-validation.css') }}" rel="stylesheet">

        <!-- Custom styles for navbar -->
        <link href="{{ asset('css/navbar.css') }}" rel="stylesheet">

        <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Open+Sans:400,300'>
        <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/icon?family=Material+Icons'>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>
    <body>
		<div class="bg-light">
		    <div class="cont_centrar">
		        <div class="cont_login">
		            <div class="cont_info_log_sign_up">
		                <div class="col_md_login">
		                    <div class="cont_ba_opcitiy">
		                        <h2>CADASTRO DE PROJETOS</h2>  
		                        <button class="btn_login" onclick="cambiar_login()">ENTRAR</button>
		                    </div>
		                </div>

		                <div class="col_md_sign_up">
		                    <div class="cont_ba_opcitiy">
		                        <h2>CONSULTA DE PROJETOS</h2>
		                        <button class="btn_sign_up" onclick="cambiar_sign_up()">ENTRAR</button>
		                    </div>
		                </div>
		            </div>

		            <div class="cont_back_info">
		                <div class="cont_img_back_">
		                    <img src="{{ 'media/icea-ufop.jpg' }}" alt=""/>
		                </div>
		            </div>

		       
		            <div class="cont_forms">
		                <div class="cont_img_back_">
		                    <img src="{{ 'media/icea-ufop.jpg' }}" alt=""/>
		                </div>
		                
		                <form method="POST" action="{{ route('login') }}">
		                    {{ csrf_field() }}
		                    <div class="cont_form_login">
		                        <a href="#" onclick="ocultar_login_sign_up()" ><i class="material-icons">&#xE5C4;</i></a>
		                        <h2>LOGIN</h2>

		                        <input type="text" name="email" placeholder="Email"/>
		                        <input type="password" name="password" placeholder="Password"/>
		                        <button class="btn_login"">INICIAR SEÇÃO</button>
		                    </div>
		                </form>

		                <form method="POST" action="{{ route('exibir') }}">
		                    {{ csrf_field() }}
		                    <div class="cont_form_sign_up">
		                        <a href="#" onclick="ocultar_login_sign_up()"><i class="material-icons">&#xE5C4;</i></a>
		                        <h2>LOGIN</h2>
		                        <input type="text" placeholder="Email"/>
		                        <input type="text" placeholder="User"/>
		                        <input type="password" placeholder="Password"/> 
		                        <button class="btn_sign_up" onclick="window.location.href='index_pic_ufop.php'">INICIAR SEÇÃO</button>
		                        <button class="btn_sign_up" onclick="window.location.href='localhost:8000/exibir'">ENTRAR COMO ANÔNIMO</button>
		                    </div>
		                </form>
		            </div>
		        </div>
		    </div>
		</div>
	    <footer class="my-5 pt-5 text-muted text-center text-small">
	        <p class="mb-1">&copy; 2017-2018 Universidade Federal de Ouro Preto</p>
	        <ul class="list-inline">
	            <li class="list-inline-item"><a href="#">Privacidade</a></li>
	            <li class="list-inline-item"><a href="#">Termos</a></li>
	            <li class="list-inline-item"><a href="#">Suporte</a></li>
	        </ul>
	    </footer>
	    <script src="{{ asset('js/index.js') }}"></script>
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
	</body>
</html>
