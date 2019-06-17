@extends('adminlte::page')
	@section('content')
	<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Gerência de usuários
        <small>alterar permissão de usuário</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Gerência de usuários</a></li>
        <li class="active">Alterar</li>
      </ol>
    </section>
    <section class="content">
    	<form method="post" action="{{ route('alterar_usuario',['id'=>$user->id]) }}">
	    {{ csrf_field() }}
	    	<div class="row">
		        <div class="col-md-12">
		          	<div class="box box-primary">
			            <div class="box-header">
			              <h3 class="box-title">Dados do usuário</h3>
			            </div>
			            @if(Session::has('success'))
			            	<div class="col-md-6 col-md-offset-3">
				            	<div class="alert alert-success alert-dismissible">
				                	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				                	<h4><i class="icon fa fa-check"></i> Sucesso</h4>
				                	{{ Session::get('success') }}
				              </div>
				           	</div>
                        @elseif(Session::has('error'))
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
	              				<div class="col-md-6">
	              					<div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
	              						<label>Nome do usuário</label>
					                    <input type="text" name="name" class="form-control" value="{{ $user->name }}"
					                           placeholder="Nome do usuário" readonly="true">
					                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
					                    @if ($errors->has('name'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('name') }}</strong>
					                        </span>
					                    @endif
					                </div>
	              				</div>
								<div class="col-md-6">
	              					<div class="form-group has-feedback {{ $errors->has('cpf') ? 'has-error' : '' }}">
	              						<label>CPF do usuário</label>
					                    <input type="text" cpf="cpf" class="form-control" value="{{ $user->cpf }}"
					                           placeholder="CPF do usuário" readonly="true">
					                    @if ($errors->has('cpf'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('cpf') }}</strong>
					                        </span>
					                    @endif
					                </div>
	              				</div>	              				
	              				<div class="col-md-6">
	              					<div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
	              						<label>Email do usuário</label>
					                    <input type="email" name="email" class="form-control" value="{{ $user->email }}"
					                           placeholder="Email do usuário" readonly="true">
					                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					                    @if ($errors->has('email'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('email') }}</strong>
					                        </span>
					                    @endif
					                </div>
	              				</div>
		              			
								<div class="col-md-6">
									<div class="form-group">
										<label>Permissão padrão</label>
										<select id="roles" name="roles" class="form-control" 
										 data-placeholder="Selecione o grupo" readonly="true">
											<option></option>
											@foreach($allRoles as $role)
											@if($role->id == $user->group->roles->id)
												<option value="{{ $role->id }}" title="{{ $role->description }}" selected="selected">{{ $role->name }}</option>
											@else
												<option value="{{ $role->id }}" title="{{ $role->description }}">{{ $role->name }}</option>
											@endif
										@endforeach
									</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Permissão adicional</label>
										<select id="extraRole" name="extraRole" class="form-control" 
										 data-placeholder="Selecione a permissão"">
											<option></option>
											@foreach($allRoles as $role)
											@if($role->id == $extraGroup)
												<option value="{{ $role->id }}" title="{{ $role->description }}" selected="selected">{{ $role->name }}</option>
											@else
												<option value="{{ $role->id }}" title="{{ $role->description }}">{{ $role->name }}</option>
											@endif
										@endforeach
									</select>
									</div>
								</div>								
		              			<div class="col-md-6 col-md-offset-3 ">
	              					<button type="submit" class="btn btn-primary btn-block btn-flat">Adicionar permissão</button>
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
		//$('.select2').select2();
		//iCheck for checkbox and radio inputs
    	$('input[type="radio"]').iCheck({
	      radioClass   : 'iradio_square-blue'
	    });

	    $('input[type="radio"]').on('ifChecked',function(event){
	    	var value = event.target.defaultValue;
	    	var url = '/usuario/vinculo-usuario/'+value;
	    	$.ajax({
	    		url:url,
	    		type:'GET',
	    		dataType:'json',
	    		headers:{
	    			'X-CSRF-Token':'{{ csrf_token() }}'
	    		},
	    		beforeSend:function(){
	    			$('#vinculo_container').hide();
	    			$('#load_select').show();
	    		}
	    	})
	    	.done(function(data){
	    		var html = "";
	    		for(item in data){
	    			html += "<option value="+data[item].id+">"+data[item].nome+"</option>";
	    		}

	    		$('#vinculo_user_id').select2('destroy').empty();
	    		$('#vinculo_user_id').html(html).promise().done(function(){
	    			$('#vinculo_user_id').select2({
	    				width:'100%'
	    			});
	    		});
	    		$('#load_select').hide();
	    		$('#vinculo_container').show();
	    	})
	    	.fail(function(jqXHR,textStatus){

			});  
	    });
	</script>
	@stop