@extends('adminlte::page')
  @section('content')
	<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Meu Perfil
      </h1>
      <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>
    <section class="content">
    	<div class="row">
        	<div class="col-md-6">
        		<div class="box box-primary">
            		<div class="box-body">
    					<p>Nome: {{$user->name}}</p>
    					<p>Email: {{$user->email}}</p>
    				</div>
    			</div>
    		</div>
    	</div>
    </section>	
  @stop	 