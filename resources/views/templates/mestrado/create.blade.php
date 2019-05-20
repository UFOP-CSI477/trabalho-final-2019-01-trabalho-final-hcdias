@extends('adminlte::page')
	@section('content')
	<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Teses de mestrado
        <small>criar nova tese de mestrado</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Teses de mestrado</a></li>
        <li class="active">Novo</li>
      </ol>
    </section>
    <section class="content">
    	<form method="post" action="{{ route('salvar_mestrado')}}">
	    {{ csrf_field() }}
	    	<div class="row">
		        <div class="col-md-12">
		          	<div class="box box-primary">
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
			            @if(Session::has('error'))
			            	<div class="col-md-6 col-md-offset-3">
				            	<div class="alert alert-error alert-dismissible">
				                	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				                	<h4><i class="icon fa fa-check"></i> Erro</h4>
				                	{{ Session::get('error') }}
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
										@if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('aluno'))
			                        		@foreach($professores as $professor)
			                        			<option value="{{$professor->id}}">{{ $professor->name }}</option>
			                        		@endforeach
			                        	@else
			                        		@foreach($professores as $professor)
			                        			@if(Auth::user()->id == $professor->id)
			                        				<option selected="selected" value="{{$professor->id}}">{{ $professor->name }}</option>
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
			              				<div class="form-group has-feedback {{ $errors->has('coorientador') ? 'has-error' : '' }}">
			              					<select id="coorientador" name="coorientador" class="form-control select2" 
			              				 data-placeholder="Selecione um professor" 
			              				 >
				              				 <option></option>
			                        		@foreach($professores as $professor)
			                        			<option value="{{$professor->id}}">{{ $professor->name }}</option>
			                        		@endforeach
			                        		</select>
			                        		@if ($errors->has('coorientador'))
						                        <span class="help-block">
						                            <strong>{{ $errors->first('coorientador') }}</strong>
						                        </span>
						                    @endif
						                </div>
		              				</div>
		              			</div>
		              			<div class="col-md-4">
		              				<label>Alunos envolvidos</label>
		              				<div class="form-group has-feedback {{ $errors->has('discente') ? 'has-error' : '' }}">
			              				<select id="discente" name="discente" class="form-control select2" 
			              				 data-placeholder="Selecione os alunos envolvidos" 
			              				 >
			              				 <option></option>
			              				@if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('professor'))
			                        		@foreach($alunos as $aluno)
			                        			<option value="{{$aluno->id}}">{{ $aluno->name }}</option>
			                        		@endforeach
			                        	@else
			                        		@foreach($alunos as $aluno)
			                        			@if(Auth::user()->id == $aluno->id)
			                        				<option selected="selected" value="{{$aluno->id}}">{{ $aluno->name }}</option>
			                        			@endif
			                        		@endforeach
			                        	@endif
		                        		
		                        		</select>
		                        		@if ($errors->has('discente'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('discente') }}</strong>
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
		          	<div class="box">
			            <div class="box-header">
			              <h3 class="box-title">Dados sobre a tese</h3>
			            </div>
			            <!-- /.box-header -->
	              		<div class="box-body">
	              			<div class="row">
	              				<div class="col-md-12">
	              					<label for="titulo_mestrado">Título</label>
	              					<div class="form-group has-feedback {{ $errors->has('titulo_mestrado') ? 'has-error' : '' }}">
		              					<input type="text" class="form-control" name="titulo_mestrado" id="titulo_mestrado" placeholder="Título da Tese">
		              					@if ($errors->has('titulo_mestrado'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('titulo_mestrado') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	              				</div>
	          					<div class="col-md-6">
	          						<label>Semestre de início</label>
	          						<div class="form-group has-feedback {{ $errors->has('semestre_inicio_mestrado') ? 'has-error' : '' }}">
		          						<select class="form-control" id="semestre_inicio_mestrado" name="semestre_inicio_mestrado">
		          							<option value="">Selecione</option>
		          							<option value='1'>1º semestre</option>
						  					<option value='2'>2º semestre</option>
		          						</select>
		          						@if ($errors->has('semestre_inicio_mestrado'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('semestre_inicio_mestrado') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	          					</div>
	          					<div class="col-md-6">
	          						<label>Ano de início</label>
	          						<div class="form-group has-feedback {{ $errors->has('ano_inicio_mestrado') ? 'has-error' : '' }}">
		          						<select class="form-control" id="ano_inicio_mestrado" name="ano_inicio_mestrado">
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
		          						@if ($errors->has('ano_inicio_mestrado'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('ano_inicio_mestrado') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	          					</div>
	          					<div class="col-md-6">
	          						<label>Abordagem</label>
	          						<div class="form-group has-feedback {{ $errors->has('abordagem_mestrado') ? 'has-error' : '' }}">
		          						<select class="form-control" id="abordagem_mestrado" name="abordagem_mestrado">
		          							<option value="">Selecione</option>
		          							@foreach($abordagem as $item)
		          								<option value="{{$item->id}}">{{$item->descricao}}</option>
		          							@endforeach
		          						</select>
		          						@if ($errors->has('abordagem_mestrado'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('abordagem_mestrado') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	          					</div>

	          					<div class="col-md-6">
	          						<label>Area</label>
	          						<div class="form-group has-feedback {{ $errors->has('area_mestrado') ? 'has-error' : '' }}">
		          						<select class="form-control" id="area_mestrado" name="area_mestrado">
		          							<option value="">Selecione</option>
		          							@foreach($area as $item)
		          								<option value="{{$item->id}}">{{$item->descricao}}</option>
		          							@endforeach
		          						</select>
		          						@if ($errors->has('area_mestrado'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('area_mestrado') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	          					</div>

	          					<div class="col-md-6">
	          						<label>Natureza</label>
	          						<div class="form-group has-feedback {{ $errors->has('natureza_mestrado') ? 'has-error' : '' }}">
		          						<select class="form-control" id="natureza_mestrado" name="natureza_mestrado">
		          							<option value="">Selecione</option>
		          							@foreach($natureza as $item)
		          								<option value="{{$item->id}}">{{$item->descricao}}</option>
		          							@endforeach
		          						</select>
		          						@if ($errors->has('natureza_mestrado'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('natureza_mestrado') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	          					</div>
	          					<div class="col-md-6">
	          						<label>Objetivo</label>
	          						<div class="form-group has-feedback {{ $errors->has('objetivo_mestrado') ? 'has-error' : '' }}">
		          						<select class="form-control" id="objetivo_mestrado" name="objetivo_mestrado">
		          							<option value="">Selecione</option>
		          							@foreach($objetivo as $item)
		          								<option value="{{$item->id}}">{{$item->descricao}}</option>
		          							@endforeach
		          						</select>
		          						@if ($errors->has('objetivo_mestrado'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('objetivo_mestrado') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	          					</div>
	          					<div class="col-md-6">
	          						<label>Procedimento</label>
	          						<div class="form-group has-feedback {{ $errors->has('procedimento_mestrado') ? 'has-error' : '' }}">
		          						<select class="form-control" id="tcc_ano_inicio" name="procedimento_mestrado">
		          							<option value="">Selecione</option>
		          							@foreach($procedimento as $item)
		          								<option value="{{$item->id}}">{{$item->descricao}}</option>
		          							@endforeach
		          						</select>
		          						@if ($errors->has('procedimento_mestrado'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('procedimento_mestrado') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	          					</div>
	          					<div class="col-md-6">
	          						<label>Sub-área</label>
	          						<div class="form-group has-feedback {{ $errors->has('subarea_mestrado') ? 'has-error' : '' }}">
		          						<select class="form-control" id="subarea_mestrado" name="subarea_mestrado">
		          							<option value="">Selecione</option>
		          								@foreach($subarea as $item)
		          								<option value="{{$item->id}}">{{$item->descricao}}</option>
		          							@endforeach
		          						</select>
		          						@if ($errors->has('subarea_mestrado'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('subarea_mestrado') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	          					</div>
	          					<div class="col-md-6">
	          						<label>Link Sisbin</label>
	          						<div class="form-group has-feedback {{ $errors->has('sisbin_mestrado') ? 'has-error' : '' }}">
		          						<input type='text' class="form-control" id="sisbin_mestrado" name="sisbin_mestrado">
		          							
		          						@if ($errors->has('sisbin_mestrado'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('sisbin_mestrado') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	          					</div>

	          					<div class="col-md-12">
	          						<div class="form-group">
			                  		<label>Resumo do projeto</label>
			                  		<textarea class="form-control" id="resumo_mestrado" name="resumo_mestrado" rows="5" placeholder="Resumo do projeto"></textarea>
			                	</div>
	          					</div>
			                </div>
	              		</div>
	              	</div>
	            </div>
	            <div class="col-md-6">
		          	<div class="box">
			            <div class="box-header">
			              <h3 class="box-title">Status da tese</h3>
			            </div>
			            <div class="box-body">
				         	<div class="form-group">
								<div class="radio">
									<label>
									  <input type="radio" name="status_mestrado" id="" value="1" checked="">
									  Tese em fase de concepção
									</label>
								</div>
								<div class="radio">
									<label>
									  <input type="radio" name="status_mestrado" id="" value="2" checked="true">
									  Tese em fase de desenvolvimento
									</label>
								</div>
								<div class="radio">
									<label>
									  <input type="radio" name="status_mestrado" id="" value="3" >
									  Tese em fase de geração de resultados
									</label>
								</div>
								<div class="radio">
									<label>
									  <input type="radio" name="status_mestrado" id="" value="4" >
									  Tese em fase de publicação
									</label>
								</div>
								<div class="radio">
									<label>
									  <input type="radio" name="status_mestrado" id="optionsRadios3" value="5" >
									  Tese publicada
									</label>
								</div>
								<div class="radio">
									<label>
									  <input type="radio" name="status_mestrado" id="optionsRadios3" value="6">
									  Tese Cancelada
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