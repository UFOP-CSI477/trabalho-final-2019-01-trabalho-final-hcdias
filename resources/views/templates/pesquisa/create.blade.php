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
			                        			<option value="{{$professor->id}}">{{ $professor->nome }}</option>
			                        		@endforeach
			                        	@else
			                        		@foreach($professores as $professor)
			                        			@if($professorId == $professor->id)
			                        				<option selected="selected" value="{{$professor->id}}">{{ $professor->nome }}</option>
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
			              				 data-placeholder="Selecione um professor" 
			              				 >
			              				 <option></option>
		                        		@foreach($professores as $professor)
		                        			<option value="{{$professor->id}}">{{ $professor->nome }}</option>
		                        		@endforeach
		                        		</select>
		              				</div>
		              			</div>
		              			<div class="col-md-4">
		              				<label>Alunos envolvidos</label>
		              				<div class="form-group has-feedback {{ $errors->has('discentes') ? 'has-error' : '' }}">
			              				<select id="discentes" name="discentes[]" class="form-control select2" 
			              				 data-placeholder="Selecione os alunos envolvidos" multiple="multiple" 
			              				 >
			              				 <option></option>
		                        		@foreach($alunos as $aluno)
		                        			<option value="{{$aluno->id}}">{{ $aluno->nome }}</option>
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
		          	<div class="box box-primary">
			            <div class="box-header">
			              <h3 class="box-title">Dados sobre o projeto</h3>
			            </div>
			            <!-- /.box-header -->
	              		<div class="box-body">
	              			<div class="row">
	              				<div class="col-md-12">
	              					<label for="pesquisa_titulo">Título</label>
	              					<div class="form-group has-feedback {{ $errors->has('pesquisa_titulo') ? 'has-error' : '' }}">
		              					<input type="text" class="form-control" name="pesquisa_titulo" id="pesquisa_titulo" placeholder="Título do Projeto">
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
		          							<option value='1'>1º semestre</option>
						  					<option value='2'>2º semestre</option>
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
		          								<option value="{{$item->id}}">{{$item->descricao}}</option>
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
		          								<option value="{{$item->id}}">{{$item->descricao}}</option>
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
		          								<option value="{{$item->id}}">{{$item->descricao}}</option>
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
		          								<option value="{{$item->id}}">{{$item->descricao}}</option>
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
		          								<option value="{{$item->id}}">{{$item->descricao}}</option>
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
		          						<select class="form-control" id="pesquisa_ano_inicio" name="pesquisa_procedimento">
		          							<option value="">Selecione</option>
		          							@foreach($procedimento as $item)
		          								<option value="{{$item->id}}">{{$item->descricao}}</option>
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
		          								<option value="{{$item->id}}">{{$item->descricao}}</option>
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
			                  		<textarea class="form-control" id="pesquisa_resumo" name="pesquisa_resumo" rows="5" placeholder="Resumo do projeto"></textarea>
			                	</div>
	          					</div>
			                </div>
	              		</div>
	              	</div>
	            </div>
	            <div class="col-md-6">
		          	<div class="box box-primary">
			            <div class="box-header">
			              <h3 class="box-title">Status do projeto</h3>
			            </div>
			            <div class="box-body">
				         	<div class="form-group">
				         		@foreach($status as $statusItem)
									<div class="radio">
										<label>
										  <input type="radio" name="pesquisa_status"  value="{{$statusItem->id}}" checked="">
										  Projeto {{$statusItem->descricao}}
										</label>
									</div>
								@endforeach
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