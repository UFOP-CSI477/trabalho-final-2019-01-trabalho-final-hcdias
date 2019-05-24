@extends('adminlte::page')
	@section('content')
	<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Trabalho de conclusão de curso
        <small>criar novo tcc</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Trabalho de conclusão de curso</a></li>
        <li class="active">Novo</li>
      </ol>
    </section>
    <section class="content">
    	<div class="row">
    		<div class="col-md-2">
    		</div>
    		<div class="col-md-8">
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
    		</div>
    	</div>
    	<form method="post" action="{{ route('salvar_tcc')}}">
	    {{ csrf_field() }}
	    	<div class="row">
		        <div class="col-md-12">
		          	<div class="box box-primary">
			            <div class="box-header">
			              <h3 class="box-title">Docentes e discentes engajados</h3>
			            </div>
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
			                        		@foreach($professores as $professor)
			                        			<option value="{{$professor->id}}">{{ $professor->name }}</option>
			                        		@endforeach
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
			              				@if(Auth::user()->hasRole('admin'))
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
		          	<div class="box box-primary">
			            <div class="box-header">
			              <h3 class="box-title">Dados sobre o trabalho</h3>
			            </div>
			            <!-- /.box-header -->
	              		<div class="box-body">
	              			<div class="row">
	              				<div class="col-md-12">
	              					<label for="titulo_tcc">Título</label>
	              					<div class="form-group has-feedback {{ $errors->has('titulo_tcc') ? 'has-error' : '' }}">
		              					<input type="text" class="form-control" name="titulo_tcc" id="titulo_tcc" placeholder="Título do trabalho">
		              					@if ($errors->has('titulo_tcc'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('titulo_tcc') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	              				</div>
	          					<div class="col-md-6">
	          						<label>Semestre de início</label>
	          						<div class="form-group has-feedback {{ $errors->has('semestre_inicio_tcc') ? 'has-error' : '' }}">
		          						<select class="form-control" id="semestre_inicio_tcc" name="semestre_inicio_tcc">
		          							<option value="">Selecione</option>
		          							<option value='1'>1º semestre</option>
						  					<option value='2'>2º semestre</option>
		          						</select>
		          						@if ($errors->has('semestre_inicio_tcc'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('semestre_inicio_tcc') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	          					</div>
	          					<div class="col-md-6">
	          						<label>Ano de início</label>
	          						<div class="form-group has-feedback {{ $errors->has('ano_inicio_tcc') ? 'has-error' : '' }}">
		          						<select class="form-control" id="ano_inicio_tcc" name="ano_inicio_tcc">
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
		          						@if ($errors->has('ano_inicio_tcc'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('ano_inicio_tcc') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	          					</div>
	          					<div class="col-md-6">
	          						<label>Abordagem</label>
	          						<div class="form-group has-feedback {{ $errors->has('abordagem_tcc') ? 'has-error' : '' }}">
		          						<select class="form-control" id="abordagem_tcc" name="abordagem_tcc">
		          							<option value="">Selecione</option>
		          							@foreach($abordagem as $item)
		          								<option value="{{$item->id}}">{{$item->descricao}}</option>
		          							@endforeach
		          						</select>
		          						@if ($errors->has('abordagem_tcc'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('abordagem_tcc') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	          					</div>

	          					<div class="col-md-6">
	          						<label>Semestre de defesa</label>
	          						<div class="form-group has-feedback {{ $errors->has('semestre_defesa_tcc') ? 'has-error' : '' }}">
		          						<select class="form-control" id="semestre_defesa_tcc" name="semestre_defesa_tcc">
		          							<option value="">Selecione</option>
		          							<option value="1">ATV29</option>
		          							<option value="2">ATV30</option>
		          							
		          						</select>
		          						@if ($errors->has('semestre_defesa_tcc'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('semestre_defesa_tcc') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	          					</div>

	          					<div class="col-md-6">
	          						<label>Area</label>
	          						<div class="form-group has-feedback {{ $errors->has('area_tcc') ? 'has-error' : '' }}">
		          						<select class="form-control" id="area_tcc" name="area_tcc">
		          							<option value="">Selecione</option>
		          							@foreach($area as $item)
		          								<option value="{{$item->id}}">{{$item->descricao}}</option>
		          							@endforeach
		          						</select>
		          						@if ($errors->has('area_tcc'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('area_tcc') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	          					</div>

	          					<div class="col-md-6">
	          						<label>Natureza</label>
	          						<div class="form-group has-feedback {{ $errors->has('natureza_tcc') ? 'has-error' : '' }}">
		          						<select class="form-control" id="natureza_tcc" name="natureza_tcc">
		          							<option value="">Selecione</option>
		          							@foreach($natureza as $item)
		          								<option value="{{$item->id}}">{{$item->descricao}}</option>
		          							@endforeach
		          						</select>
		          						@if ($errors->has('natureza_tcc'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('natureza_tcc') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	          					</div>
	          					<div class="col-md-6">
	          						<label>Objetivo</label>
	          						<div class="form-group has-feedback {{ $errors->has('objetivo_tcc') ? 'has-error' : '' }}">
		          						<select class="form-control" id="objetivo_tcc" name="objetivo_tcc">
		          							<option value="">Selecione</option>
		          							@foreach($objetivo as $item)
		          								<option value="{{$item->id}}">{{$item->descricao}}</option>
		          							@endforeach
		          						</select>
		          						@if ($errors->has('objetivo_tcc'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('objetivo_tcc') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	          					</div>
	          					<div class="col-md-6">
	          						<label>Procedimento</label>
	          						<div class="form-group has-feedback {{ $errors->has('procedimento_tcc') ? 'has-error' : '' }}">
		          						<select class="form-control" id="tcc_ano_inicio" name="procedimento_tcc">
		          							<option value="">Selecione</option>
		          							@foreach($procedimento as $item)
		          								<option value="{{$item->id}}">{{$item->descricao}}</option>
		          							@endforeach
		          						</select>
		          						@if ($errors->has('procedimento_tcc'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('procedimento_tcc') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	          					</div>
	          					<div class="col-md-6">
	          						<label>Sub-área</label>
	          						<div class="form-group has-feedback {{ $errors->has('subarea_tcc') ? 'has-error' : '' }}">
		          						<select class="form-control" id="subarea_tcc" name="subarea_tcc">
		          							<option value="">Selecione</option>
		          								@foreach($subarea as $item)
		          								<option value="{{$item->id}}">{{$item->descricao}}</option>
		          							@endforeach
		          						</select>
		          						@if ($errors->has('subarea_tcc'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('subarea_tcc') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	          					</div>
	          					<div class="col-md-6">
	          						<label>Link Sisbin</label>
	          						<div class="form-group has-feedback {{ $errors->has('sisbin_tcc') ? 'has-error' : '' }}">
		          						<input type='text' class="form-control" id="sisbin_tcc" name="sisbin_tcc">
		          							
		          						@if ($errors->has('sisbin_tcc'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('sisbin_tcc') }}</strong>
					                        </span>
					                    @endif
	          						</div>
	          					</div>

	          					<div class="col-md-12">
	          						<div class="form-group">
			                  		<label>Resumo do projeto</label>
			                  		<textarea class="form-control" id="resumo_tcc" name="resumo_tcc" rows="5" placeholder="Resumo do projeto"></textarea>
			                	</div>
	          					</div>
			                </div>
	              		</div>
	              	</div>
	            </div>
	            <div class="col-md-6">
		          	<div class="box box-primary">
			            <div class="box-header">
			              <h3 class="box-title">Status do trabalho</h3>
			            </div>
			            <div class="box-body">
				         	<div class="form-group">
								<div class="radio">
									<label>
									  <input type="radio" name="status_tcc" id="" value="1" checked="">
									  Trabalho em fase de concepção
									</label>
								</div>
								<div class="radio">
									<label>
									  <input type="radio" name="status_tcc" id="" value="2" checked="true">
									  Trabalho em fase de desenvolvimento
									</label>
								</div>
								<div class="radio">
									<label>
									  <input type="radio" name="status_tcc" id="" value="3" >
									  Trabalho em fase de geração de resultados
									</label>
								</div>
								<div class="radio">
									<label>
									  <input type="radio" name="status_tcc" id="" value="4" >
									  Trabalho em fase de publicação
									</label>
								</div>
								<div class="radio">
									<label>
									  <input type="radio" name="status_tcc" id="optionsRadios3" value="5" >
									  Trabalho publicado
									</label>
								</div>
								<div class="radio">
									<label>
									  <input type="radio" name="status_tcc" id="optionsRadios3" value="6">
									  Trabalho cancelado
									</label>
								</div>
	                		</div>
	                		<div class="form-group">
	                			<div class="checkbox">
				                    <label>
				                      <input type="checkbox" name="ocultar">
				                      Ocultar em consultas realizadas por usuários não cadastrados
				                    </label>
				                  </div>
	                		</div>
	                	</div>
            		</div>
            		<div class="box box-primary">
			            <div class="box-header">
			              <h3 class="box-title">Banca de apresentação</h3>
			            </div>
			            <div class="box-body">
			            	<div class="row">
			            		<div class="col-md-6">
					         		<div class="form-group">
										<label>Data de apresentação:</label>

										<div class="input-group date">
										  <div class="input-group-addon">
										    <i class="fa fa-calendar"></i>
										  </div>
										  <input type="text" class="form-control pull-right" id="banca_data" name="banca_data">
										</div>
		                			</div>
		                		</div>
		                	</div>
	                		<div class="row">
	                			<div class="col-md-9">
	                				<div class="form-group">
			              				<label>Selecione até 5 professores</label>
			              				<div class="form-group has-feedback {{ $errors->has('banca_tcc') ? 'has-error' : '' }}">
			              					<select id="banca_tcc" name="banca_tcc[]" class="form-control select2" 
			              				 data-placeholder="Selecione um professor" multiple="multiple" 
			              				 >
				              				 <option></option>
			                        		@foreach($professores as $professor)
			                        			<option value="{{$professor->id}}">{{ $professor->name }}</option>
			                        		@endforeach
			                        		</select>
			                        		@if ($errors->has('banca_tcc'))
						                        <span class="help-block">
						                            <strong>{{ $errors->first('banca_tcc') }}</strong>
						                        </span>
						                    @endif
						                </div>
		                			</div>
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
			$('.select2').select2({
				width:'100%'
			});
	    	//iCheck for checkbox and radio inputs
		    $('input[type="checkbox"], input[type="radio"]').iCheck({
		      checkboxClass: 'icheckbox_square-blue',
		      radioClass   : 'iradio_square-blue',
		      increaseArea: '20%'
		    });

		    $("#banca_data").daterangepicker({
		    	singleDatePicker:true,
		    	timePicker:true,
		    	timePicker24Hour:true,
		    	locale: {
				    format: 'DD/MM/YYYY H:mm '
    			}
		    });
		</script>
	@stop