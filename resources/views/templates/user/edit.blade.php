@extends('adminlte::page')
	@section('content')
	<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Gerência de usuários
        <small>alterar usuário</small>
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
		        <div class="col-md-6">
		          	<div class="box">
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
			            @endif
			            <!-- /.box-header -->
	              		<div class="box-body">
	              			<div class="row">
	              				<div class="col-md-12">
	              					<div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
					                    <input type="text" name="name" class="form-control" value="{{ $user->name }}"
					                           placeholder="Nome do usuário">
					                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
					                    @if ($errors->has('name'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('name') }}</strong>
					                        </span>
					                    @endif
					                </div>
	              				</div>
	              				<div class="col-md-12">
	              					<div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
					                    <input type="email" name="email" class="form-control" value="{{ $user->email }}"
					                           placeholder="Email do usuário">
					                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					                    @if ($errors->has('email'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('email') }}</strong>
					                        </span>
					                    @endif
					                </div>
	              				</div>
		              			
		              			<div class="col-md-12">
		              				<div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
					                    <input type="password" name="password" class="form-control"
					                           placeholder="Digite uma senha">
					                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
					                    @if ($errors->has('password'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('password') }}</strong>
					                        </span>
					                    @endif
					                </div>
		              			</div>

		              			<div class="col-md-12">
		              				<div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
					                    <input type="password" name="password_confirmation" class="form-control"
					                           placeholder="Confirme a senha">
					                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
					                    @if ($errors->has('password_confirmation'))
					                        <span class="help-block">
					                            <strong>{{ $errors->first('password_confirmation') }}</strong>
					                        </span>
					                    @endif
					                </div>
		              			</div>
		              			<div class="col-md-12">
		              				<div class="form-group">
			              				<select id="roles" name="roles[]" class="form-control select2" 
			              				 data-placeholder="Selecione as permissões" 
			              				 multiple="multiple">
			              					<option></option>
			              					@foreach($allRoles as $role)
			                        			@if(in_array($role->id,$rolesId))
			                        				<option value="{{ $role->id }}" title="{{ $role->description }}" selected="selected">{{ $role->name }}</option>
			                        			@else
			                        				<option value="{{ $role->id }}" title="{{ $role->description }}">{{ $role->name }}</option>
			                        			@endif
			                        			
		                        			@endforeach		                        
		                        		</select>
		              				</div>
		              			</div>
		              			<div class="col-md-6 col-md-offset-3 ">
	              					<button type="submit" class="btn btn-primary btn-block btn-flat">Alterar</button>
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
	</script>
	@stop