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
    					<p>Nome: {{$professores["nome"]}}</p>
    					<p>Email: {{$professores["email"]}}</p>
    					<p>Departamento: {{$departamentos["descricao"]}}</p>
    				</div>
    			</div>
    		</div>
    	</div>
    </section>	
  @stop	 