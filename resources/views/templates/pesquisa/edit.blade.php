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
	              					<label>Professor orientador</label>
		              				<div class="form-group has-feedback {{ $errors->has('orientador') ? 'has-error' : '' }}">
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
		                        		@if ($errors->has('orientador'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('orientador') }}</strong>
					                        </span>
					                    @endif
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
		              				<div class="form-group has-feedback {{ $errors->has('discentes') ? 'has-error' : '' }}">
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
		                        		@if ($errors->has('discentes'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('discentes') }}</strong>
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
		        <div class="col-md-6">
		          	<div class="box box">
			            <div class="box-header">
			              <h3 class="box-title">Dados sobre o projeto</h3> 
			            </div>
			            <!-- /.box-header -->
	              		<div class="box-body">
	              			<div class="row">
	              				<div class="col-md-12">
	              					<label for="pesquisa_titulo">Título</label>
	              					<div class="form-group has-feedback {{ $errors->has('pesquisa_titulo') ? 'has-error' : '' }}">
		              					<input type="text" class="form-control" name="pesquisa_titulo" id="pesquisa_titulo" placeholder="" value="{{$pesquisa->pesquisa_titulo}}">
										@if ($errors->has('pesquisa_titulo'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('pesquisa_titulo') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	              				</div>
	          					
	          					<div class="col-md-6">
	          						<label>Semestre de início</label>
	          						<div class="form-group has-feedback {{ $errors->has('pesquisa_semestre_inicio') ? 'has-error' : '' }}">
		          						<select class="form-control" id="pesquisa_semestre_inicio" name="pesquisa_semestre_inicio">
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
		          						@if ($errors->has('pesquisa_semestre_inicio'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('pesquisa_semestre_inicio') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	          					</div>
	          					<div class="col-md-6">
	          						<label>Ano de início</label>
	          						<div class="form-group has-feedback {{ $errors->has('pesquisa_ano_inicio') ? 'has-error' : '' }}">
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
		          						@if ($errors->has('pesquisa_ano_inicio'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('pesquisa_ano_inicio') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	          					</div>
	          					<div class="col-md-6">
	          						<label>Abordagem</label>
	          						<div class="form-group has-feedback {{ $errors->has('pesquisa_abordagem') ? 'has-error' : '' }}">
		          						<select class="form-control" id="pesquisa_abordagem" name="pesquisa_abordagem">
		          							<option value="">Selecione</option>
		          							@foreach($abordagem as $item)
		          								@if($item->id == $pesquisa->abordagem_pesquisa_id)
		          									<option value="{{$item->id}}" selected="selected">{{$item->descricao}}</option>
		          								@else
		          									<option value="{{$item->id}}">{{$item->descricao}}</option>
		          								@endif
		          							@endforeach
		          						</select>
		          						@if ($errors->has('pesquisa_abordagem'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('pesquisa_abordagem') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	          					</div>
	          					<div class="col-md-6">
	          						<label>Agência</label>
	          						<div class="form-group has-feedback {{ $errors->has('pesquisa_agencia') ? 'has-error' : '' }}">
		          						<select class="form-control" id="pesquisa_agencia" name="pesquisa_agencia">
		          							<option value="">Selecione</option>
		          							@foreach($agencia as $item)
		          								@if($item->id == $pesquisa->agencia_pesquisa_id)
		          									<option value="{{$item->id}}" selected="selected">{{$item->descricao}}</option>
		          								@else
		          									<option value="{{$item->id}}">{{$item->descricao}}</option>
		          								@endif
		          							@endforeach
		          						</select>
		          						@if ($errors->has('pesquisa_agencia'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('pesquisa_agencia') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	          					</div>

	          					<div class="col-md-6">
	          						<label>Area</label>
	          						<div class="form-group has-feedback {{ $errors->has('pesquisa_area') ? 'has-error' : '' }}">
		          						<select class="form-control" id="pesquisa_area" name="pesquisa_area">
		          							<option value="">Selecione</option>
		          							@foreach($area as $item)
		          								@if($item->id == $pesquisa->area_pesquisa_id)
		          									<option value="{{$item->id}}" selected="selected">{{$item->descricao}}</option>
		          								@else
		          									<option value="{{$item->id}}">{{$item->descricao}}</option>
		          								@endif
		          							@endforeach
		          						</select>
		          						@if ($errors->has('pesquisa_area'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('pesquisa_area') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	          					</div>

	          					<div class="col-md-6">
	          						<label>Natureza</label>
	          						<div class="form-group has-feedback {{ $errors->has('pesquisa_natureza') ? 'has-error' : '' }}">
		          						<select class="form-control" id="pesquisa_natureza" name="pesquisa_natureza">
		          							<option value="">Selecione</option>
		          							@foreach($natureza as $item)
		          								@if($item->id == $pesquisa->natureza_pesquisa_id)
		          									<option value="{{$item->id}}" selected="selected">{{$item->descricao}}</option>
		          								@else
		          									<option value="{{$item->id}}">{{$item->descricao}}</option>
		          								@endif
		          							@endforeach
		          						</select>
		          						@if ($errors->has('pesquisa_natureza'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('pesquisa_natureza') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	          					</div>
	          					<div class="col-md-6">
	          						<label>Objetivo</label>
	          						<div class="form-group has-feedback {{ $errors->has('pesquisa_objetivo') ? 'has-error' : '' }}">
		          						<select class="form-control" id="pesquisa_objetivo" name="pesquisa_objetivo">
		          							<option value="">Selecione</option>
		          							@foreach($objetivo as $item)
		          								@if($item->id == $pesquisa->objetivo_pesquisa_id)
		          									<option value="{{$item->id}}" selected="selected">{{$item->descricao}}</option>
		          								@else
		          									<option value="{{$item->id}}">{{$item->descricao}}</option>
		          								@endif
		          							@endforeach
		          						</select>
		          						@if ($errors->has('pesquisa_objetivo'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('pesquisa_objetivo') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	          					</div>
	          					<div class="col-md-6">
	          						<label>Procedimento</label>
	          						<div class="form-group has-feedback {{ $errors->has('pesquisa_procedimento') ? 'has-error' : '' }}">
		          						<select class="form-control" id="pesquisa_procedimento" name="pesquisa_procedimento">
		          							<option value="">Selecione</option>
		          							@foreach($procedimento as $item)
		          								@if($item->id == $pesquisa->procedimentos_pesquisa_id)
		          									<option value="{{$item->id}}" selected="selected">{{$item->descricao}}</option>
		          								@else
		          									<option value="{{$item->id}}">{{$item->descricao}}</option>
		          								@endif
		          							@endforeach
		          						</select>
		          						@if ($errors->has('pesquisa_procedimento'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('pesquisa_procedimento') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	          					</div>
	          					<div class="col-md-6">
	          						<label>Sub-área</label>
	          						<div class="form-group has-feedback {{ $errors->has('pesquisa_subarea') ? 'has-error' : '' }}">
		          						<select class="form-control" id="pesquisa_subarea" name="pesquisa_subarea">
		          							<option value="">Selecione</option>
		          								@foreach($subarea as $item)
			          								@if($item->id == $pesquisa->sub_area_pesquisa_id)
			          									<option value="{{$item->id}}" selected="selected">{{$item->descricao}}</option>
			          								@else
		          										<option value="{{$item->id}}">{{$item->descricao}}</option>
		          									@endif
		          								@endforeach
		          						</select>
		          						@if ($errors->has('pesquisa_subarea'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('pesquisa_subarea') }}</strong>
					                        </span>
					                    @endif
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
