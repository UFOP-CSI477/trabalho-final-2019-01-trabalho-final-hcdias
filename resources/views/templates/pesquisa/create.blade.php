@extends('adminlte::page')
	@section('content')
	<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Projetos de Pesquisa
        <small>criar novo projeto de pesquisa</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Projetos de Pesquisa</a></li>
        <li class="active">Novo</li>
      </ol>
    </section>
    <section class="content">
    	<form method="post" action="{{ route('salvar_pesquisa')}}">
	    {{ csrf_field() }}
	    	<div class="row">
		        <div class="col-md-12">
		        @if ($errors->any())
			      <div class="alert alert-danger">
			          <ul>
			              @foreach ($errors->all() as $error)
			                  <li>{{ $error }}</li>
			              @endforeach
			          </ul>
			      </div>
			      @endif
		          	<div class="box">
			            <div class="box-header">
			              <h3 class="box-title">Docentes e discentes engajados</h3>
			            </div>
			            <!-- /.box-header -->
	              		<div class="box-body">
	              			<div class="row">
	              				<div class="col-md-4">
		              				<div class="form-group">
			              				<label>Professor orientador</label>
			              				<select id="orientador" name="orientador" class="form-control select2" 
			              				 data-placeholder="Selecione um professor" 
			              				 >
			              				 <option></option>
		                        		@foreach($professores as $professor)
		                        			<option value="{{$professor->id}}">{{ $professor->professor_nome }}</option>
		                        		@endforeach
		                        		</select>
		              				</div>
		              			</div>
		              			<div class="col-md-4">
		              				<div class="form-group">
			              				<label>Professor coorientador</label>
			              				<select id="coorientador" name="coorientador" class="form-control select2" 
			              				 data-placeholder="Selecione um professor" 
			              				 >
			              				 <option></option>
		                        		@foreach($professores as $professor)
		                        			<option value="{{$professor->id}}">{{ $professor->professor_nome }}</option>
		                        		@endforeach
		                        		</select>
		              				</div>
		              			</div>
		              			<div class="col-md-4">
		              				<div class="form-group">
			              				<label>Alunos envolvidos</label>
			              				<select id="discentes" name="discentes[]" class="form-control select2" 
			              				 data-placeholder="Selecione os alunos envolvidos" multiple="multiple" 
			              				 >
			              				 <option></option>
		                        		@foreach($alunos as $aluno)
		                        			<option value="{{$aluno->id}}">{{ $aluno->aluno_nome }}</option>
		                        		@endforeach
		                        		</select>
		              				</div>
		              			</div>
	              			</div>
	              		</div>
					</div>
				</div>
			</div>
			<div class="row">
		        <div class="col-md-6">
		          	<div class="box box">
			            <div class="box-header">
			              <h3 class="box-title">Dados sobre o projeto</h3>
			            </div>
			            <!-- /.box-header -->
	              		<div class="box-body">
	              			<div class="row">
	              				<div class="col-md-12">
	              					<div class="form-group">
	          							<label for="pesquisa_titulo">Título</label>
		              					<input type="text" class="form-control" name="pesquisa_titulo" id="pesquisa_titulo" placeholder="Título do Projeto">
	          						</div>
	              				</div>
	          					
	          					<div class="col-md-6">
	          						<div class="form-group">
	          							<label>Semestre de início</label>
		          						<select class="form-control" id="pesquisa_semestre_inicio" name="pesquisa_semestre_inicio">
		          							<option></option>
		          							<option value='1'>1º semestre</option>
						  					<option value='2'>2º semestre</option>
		          						</select>
	          						</div>
	          					</div>
	          					<div class="col-md-6">
	          						<div class="form-group">
	          							<label>Ano de início</label>
		          						<select class="form-control" id="pesquisa_ano_inicio" name="pesquisa_ano_inicio">
		          							<option value="">Selecione</option>
											<option value='2010'>2010</option>
											<option value='2011'>2011</option>
											<option value='2012'>2012</option>
											<option value='2013'>2013</option>
											<option value='2014'>2014</option>
											<option value='2015'>2015</option>
											<option value='2016'>2016</option>
											<option value='2017'>2017</option>
											<option value='2018'>2018</option>
											<option value='2019'>2019</option>
											<option value='2020'>2020</option>
											<option value='2021'>2021</option>
		          						</select>
	          						</div>
	          					</div>

	          					<div class="col-md-12">
	          						<div class="form-group">
			                  		<label>Resumo do projeto</label>
			                  		<textarea class="form-control" id="pesquisa_resumo" name="pesquisa_resumo" rows="5" placeholder="Resumo do projeto"></textarea>
			                	</div>
	          					</div>
			                </div>
	              		</div>
	              	</div>
	            </div>
	            <div class="col-md-6">
		          	<div class="box">
			            <div class="box-header">
			              <h3 class="box-title">Status do projeto</h3>
			            </div>
			            <div class="box-body">
				         	<div class="form-group">
								<div class="radio">
									<label>
									  <input type="radio" name="pesquisa_status" id="" value="1" checked="">
									  Projeto em fase de concepção
									</label>
								</div>
								<div class="radio">
									<label>
									  <input type="radio" name="pesquisa_status" id="" value="2" checked="true">
									  Projeto em fase de desenvolvimento
									</label>
								</div>
								<div class="radio">
									<label>
									  <input type="radio" name="pesquisa_status" id="" value="3" >
									  Projeto em fase de geração de resultados
									</label>
								</div>
								<div class="radio">
									<label>
									  <input type="radio" name="pesquisa_status" id="" value="4" >
									  Projeto em fase de publicação
									</label>
								</div>
								<div class="radio">
									<label>
									  <input type="radio" name="pesquisa_status" id="optionsRadios3" value="5" >
									  Projeto publicado
									</label>
								</div>
								<div class="radio">
									<label>
									  <input type="radio" name="pesquisa_status" id="optionsRadios3" value="6">
									  Projeto Cancelado
									</label>
								</div>
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
		$('.select2').select2();
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"], input[type="radio"]').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass   : 'iradio_square-blue',
      increaseArea: '20%'
    });
	</script>
	@stop