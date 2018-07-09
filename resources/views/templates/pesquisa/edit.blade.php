@extends('adminlte::page')
	@section('content')
	<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Projetos de Pesquisa
        <small>editar projeto de pesquisa</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Projetos de Pesquisa</a></li>
        <li class="active">Editar</li>
      </ol>
    </section>
    <section class="content">
    	<form method="post" action="{{ route('atualizar_pesquisa',['id'=>$pesquisa->id])}}">
	    {{ csrf_field() }}
	    	<div class="row">
		        <div class="col-md-12">
			      	<div class="box">
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
		              				<div class="form-group">
			              				<label>Professor orientador</label>
			              				<select id="orientador" name="orientador" class="form-control select2" 
			              				 data-placeholder="Selecione um professor" 
			              				 >
			              					<option></option>
			              					@if(Auth::user()->hasRole('admin'))
			              						@foreach($professores as $professor)
			                        				@if(array_key_exists($professor->id,$professorPesquisas) && $professorPesquisas[$professor->id]->pivot->professor_papel_id == ProfessorPapel::ORIENTADOR)
			                        					<option value="{{ $professor->id }}" selected="selected">{{ $professor->professor_nome }}</option>
			                        				@else	
			                        					<option value="{{ $professor->id }}">{{ $professor->professor_nome }}</option>
			                        				@endif
			                        			@endforeach
			              					@else
			              						@foreach($professores as $professor)
			                        				@if(array_key_exists($professor->id,$professorPesquisas) && $professorPesquisas[$professor->id]->pivot->professor_papel_id == ProfessorPapel::ORIENTADOR)
			                        					<option value="{{ $professor->id }}" selected="selected">{{ $professor->professor_nome }}</option>
			                        				@endif
			                        			@endforeach
			              					@endif
			                        		
		                        		</select>
		              				</div>
		              			</div>
		              			<div class="col-md-4">
		              				<div class="form-group">
			              				<label>Professor coorientador</label>
			              				<select id="coorientador" name="coorientador" class="form-control select2" 
			              				data-placeholder="Selecione um professor" >
			              					<option></option>
			              					@foreach($professores as $professor)
			                        			@if(array_key_exists($professor->id,$professorPesquisas) && $professorPesquisas[$professor->id]->pivot->professor_papel_id == ProfessorPapel::COORIENTADOR)
			                        				<option value="{{ $professor->id }}" selected="selected">{{ $professor->professor_nome }}</option>
			                        			@else
			                        				<option value="{{ $professor->id }}">{{ $professor->professor_nome }}</option>
			                        			@endif
			                        		@endforeach
			              				</select>
		              				</div>
		              			</div>
		              			<div class="col-md-4">
		              				<div class="form-group">
			              				<label>Alunos envolvidos</label>
			              				<select id="discentes" name="discentes[]" class="form-control select2" 
			              				 data-placeholder="" multiple="multiple" 
			              				 >
			              				 <option></option>
			              				 @foreach($alunos as $aluno)
			              				 	@if(in_array($aluno->id,$alunoPesquisas))
			              				 		<option value="{{ $aluno->id }}" selected="selected">{{ $aluno->aluno_nome }}</option>
			              				 	@else
			              				 		<option value="{{ $aluno->id }}" >{{ $aluno->aluno_nome }}</option>
			              				 	@endif
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
		              					<input type="text" class="form-control" name="pesquisa_titulo" id="pesquisa_titulo" placeholder="" value="<?php
		              						echo $pesquisa->pesquisa_titulo;
										?>"
										>
	          						</div>
	              				</div>
	          					
	          					<div class="col-md-6">
	          						<div class="form-group">
	          							<label>Semestre de início</label>
		          						<select class="form-control" id="pesquisa_semestre_inicio" name="pesquisa_semestre_inicio" index = "2">
		          							<option value="">Selecione</option>
		          							<?php
		          								for ($semester = 1; $semester < 3; $semester++){
		          									if ($semester == $pesquisa->pesquisa_semestre_inicio){
		          										echo "<option value='" . $semester . "' selected = 'selected'>" . $semester . "º semestre</option>";
		          									}else{
		          										echo "<option value='" . $semester . "'>" . $semester . "º semestre</option>";
		          									}
		          								}
		          							?>
		          						</select>
	          						</div>
	          					</div>
	          					<div class="col-md-6">
	          						<div class="form-group">
	          							<label>Ano de início</label>
		          						<select class="form-control" id="pesquisa_ano_inicio" name="pesquisa_ano_inicio">
		          							<option value="">Selecione</option>
		          							<?php
		          								for ($year = 2010; $year < 2022; $year++){
		          									if ($year == $pesquisa->pesquisa_ano_inicio){
		          										echo "<option value='" . $year . "' selected = 'selected'>" . $year . "</option>";
		          									}else{
		          										echo "<option value='" . $year . "'>" . $year . "</option>";
		          									}
		          								}
		          							?>
		          						</select>
	          						</div>
	          					</div>

	          					<div class="col-md-12">
	          						<div class="form-group">
			                  		<label>Resumo do projeto</label>
			                  		<textarea class="form-control" id="pesquisa_resumo" name="pesquisa_resumo" rows="5" placeholder=""><?php
		              						echo $pesquisa->pesquisa_resumo;
										?>
			                  		</textarea>
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
				         	<?php
				         		$array = [
				         			1 => "Projeto em fase de concepção",
				         			2 => "Projeto em fase de desenvolvimento",
				         			3 => "Projeto em fase de geração de resultados",
				         			4 => "Projeto em fase de publicação",
				         			5 => "Projeto publicado",
				         			6 => "Projeto cancelado",
				         		];

		          				for ($status = 1; $status < 7; $status++){
		          					if ($status == $pesquisa->pesquisa_status){
		          						echo "<div class='radio'>
												<label>
									  				<input type='radio' name='pesquisa_status' id='optionsRadios" . $status . "' value='" . $status . "' checked='checked'>" . $array[$status] . "
												</label>
											</div>";
		          					}else{
		          						echo "<div class='radio'>
												<label>
									  				<input type='radio' name='pesquisa_status' id='optionsRadios" . $status . "' value='" . $status . "'>" . $array[$status] . "
												</label>
											</div>";
		          					}
		          				}
				         	?>
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
    })
	</script>
	@stop
