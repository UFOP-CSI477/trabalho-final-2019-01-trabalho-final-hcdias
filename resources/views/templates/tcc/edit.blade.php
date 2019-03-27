@extends('adminlte::page')
	@section('content')
	<!-- Content Header (Page header) -->
	<?php //dd($errors);?>
    <section class="content-header">
      <h1>
        Teses de conclusão de curso
        <small>editar tese</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Teses de conclusão de curso</a></li>
        <li class="active">Editar</li>
      </ol>
    </section>
    <section class="content">
    	<form method="post" action="{{ route('atualizar_tcc',['id'=>$tcc->id])}}">
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
			              					@if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('aluno'))
			              						@foreach($professores as $professor)
			                        				@if($professor->id == $tcc->orientador_tcc_id)
			                        					<option value="{{ $professor->id }}" selected="selected">{{ $professor->nome }}</option>
			                        				@else
			                        					<option value="{{ $professor->id }}">{{ $professor->nome }}</option>
			                        				@endif
			                        			@endforeach
			              					@else
			              						@foreach($professores as $professor)
			                        				@if($professor->id == $tcc->orientador_tcc_id)
			                        					<option value="{{ $professor->id }}" selected="selected">{{ $professor->nome }}</option>
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
			                        			@if($professor->id == $tcc->coorientador_tcc_id)
			                        				<option value="{{ $professor->id }}" selected="selected">{{ $professor->nome }}</option>
			                        			@else
			                        				<option value="{{ $professor->id }}">{{ $professor->nome }}</option>
			                        			@endif
			                        		@endforeach
			              				</select>
		              				</div>
		              			</div>
		              			<div class="col-md-4">
		              				<div class="form-group has-feedback {{ $errors->has('discente') ? 'has-error' : '' }}">
			              				<label>Alunos envolvidos</label>
			              				<select id="discente" name="discente" class="form-control select2" 
			              				 data-placeholder="">
			              				 <option></option>
			              				 @if(Auth::user()->hasRole('admin'))
			                        		@foreach($alunos as $aluno)
			                        			@if($tcc->aluno_tcc_id == $aluno->id)
			                        				<option selected="selected" value="{{$aluno->id}}">{{ $aluno->nome }}</option>
			                        			@else
			                        			<option value="{{$aluno->id}}">{{ $aluno->nome }}</option>
			                        			@endif
			                        		@endforeach
			                        	@else
			                        		@foreach($alunos as $aluno)
			                        			@if($aluno->id == $tcc->aluno_tcc_id)
			                        			<option selected="selected" value="{{$aluno->id}}">{{ $aluno->nome }}</option>
			                        			@endif
			                        		@endforeach
			                        	@endif
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
		          	<div class="box">
			            <div class="box-header">
			              <h3 class="box-title">Dados sobre a tese</h3> 
			            </div>
			            <!-- /.box-header -->
	              		<div class="box-body">
	              			<div class="row">
	              				<div class="col-md-12">
	              					<label for="titulo_tcc">Título</label>
	              					<div class="form-group has-feedback {{ $errors->has('titulo_tcc') ? 'has-error' : '' }}">
		              					<input type="text" class="form-control" name="titulo_tcc" id="titulo_tcc" placeholder="" value="{{$tcc->titulo_tcc}}">
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
		          							<?php
		          								for ($semester = 1; $semester < 3; $semester++){
		          									if ($semester == $tcc->semestre_inicio_tcc){
		          										echo "<option value='" . $semester . "' selected = 'selected'>" . $semester . "º semestre</option>";
		          									}else{
		          										echo "<option value='" . $semester . "'>" . $semester . "º semestre</option>";
		          									}
		          								}
		          							?>
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
		          							<?php
		          								for ($year = 2010; $year < 2022; $year++){
		          									if ($year == $tcc->ano_inicio_tcc){
		          										echo "<option value='" . $year . "' selected = 'selected'>" . $year . "</option>";
		          									}else{
		          										echo "<option value='" . $year . "'>" . $year . "</option>";
		          									}
		          								}
		          							?>
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
		          								@if($item->id == $tcc->abordagem_tcc_id)
		          									<option value="{{$item->id}}" selected="selected">{{$item->descricao}}</option>
		          								@else
		          									<option value="{{$item->id}}">{{$item->descricao}}</option>
		          								@endif
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
		          							<option value="1" {{ $tcc->semestre_defesa_tcc == 1 ? "selected='selected'" : ""}}>ATV29</option>
		          							
		          							<option value="2" {{ $tcc->semestre_defesa_tcc == 2 ? "selected='selected'"  : ""}}>ATV30</option>
		          							
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
		          								@if($item->id == $tcc->area_tcc_id)
		          									<option value="{{$item->id}}" selected="selected">{{$item->descricao}}</option>
		          								@else
		          									<option value="{{$item->id}}">{{$item->descricao}}</option>
		          								@endif
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
		          								@if($item->id == $tcc->natureza_tcc_id)
		          									<option value="{{$item->id}}" selected="selected">{{$item->descricao}}</option>
		          								@else
		          									<option value="{{$item->id}}">{{$item->descricao}}</option>
		          								@endif
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
		          								@if($item->id == $tcc->objetivo_tcc_id)
		          									<option value="{{$item->id}}" selected="selected">{{$item->descricao}}</option>
		          								@else
		          									<option value="{{$item->id}}">{{$item->descricao}}</option>
		          								@endif
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
		          						<select class="form-control" id="procedimento_tcc" name="procedimento_tcc">
		          							<option value="">Selecione</option>
		          							@foreach($procedimento as $item)
		          								@if($item->id == $tcc->procedimentos_tcc_id)
		          									<option value="{{$item->id}}" selected="selected">{{$item->descricao}}</option>
		          								@else
		          									<option value="{{$item->id}}">{{$item->descricao}}</option>
		          								@endif
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
			          								@if($item->id == $tcc->sub_area_tcc_id)
			          									<option value="{{$item->id}}" selected="selected">{{$item->descricao}}</option>
			          								@else
		          										<option value="{{$item->id}}">{{$item->descricao}}</option>
		          									@endif
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
		          						<input type='text' class="form-control" id="sisbin_tcc" name="sisbin_tcc" value="{{$tcc->sisbin_tcc}}">
		          							
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
			                  		<textarea class="form-control" id="resumo_tcc" name="resumo_tcc" rows="5" placeholder=""><?php
		              						echo $tcc->resumo_tcc;
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
		          					if ($status == $tcc->status_tcc){
		          						echo "<div class='radio'>
												<label>
									  				<input type='radio' name='status_tcc' id='optionsRadios" . $status . "' value='" . $status . "' checked='checked'>" . $array[$status] . "
												</label>
											</div>";
		          					}else{
		          						echo "<div class='radio'>
												<label>
									  				<input type='radio' name='status_tcc' id='optionsRadios" . $status . "' value='" . $status . "'>" . $array[$status] . "
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
	                	</div>
            		</div>
            		<div class="box">
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
										  <input type="text" class="form-control pull-right" id="banca_data" name="banca_data" value="{{ !is_null($tcc->banca_data) ? date('d/m/Y H:M',strtotime($tcc->banca_data)) : ""}}">
										</div>
		                			</div>
		                		</div>
		                	</div>
		                	<div class="row">
		                		<div class="form-group">
		                			<div class="col-md-12">
		                				<div class="form-group">
			              				<label>Selecione 5 professores</label>
			              				<div class="form-group has-feedback {{ $errors->has('banca_tcc') ? 'has-error' : '' }}">
			              					<select id="banca_tcc" name="banca_tcc[]" class="form-control select2" 
			              				 data-placeholder="Selecione um professor" multiple="multiple" 
			              				 >
				              				 <option></option>
			                        		@foreach($professores as $professor)
			                        			@if(in_array($professor->id,$professoresBanca))
			                        			<option selected="selected" value="{{$professor->id}}">{{ $professor->nome }}</option>
			                        			@else
			                        			<option value="{{$professor->id}}">{{ $professor->nome }}</option>
			                        			@endif
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
