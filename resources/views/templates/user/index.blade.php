@extends('adminlte::page')
	@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Gerência de usuários
        <small>pesquisar usuários</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Gerência de usuários</a></li>
        <li class="active">Busca</li>
      </ol>
    </section>
    <section class="content">
	    <div class="row">
	        <div class="col-xs-12">
	          	<div class="box">
		            <div class="box-header">
		              <!-- <h3 class="box-title">Pesquisas Cadastradas</h3> -->
		            </div>
		            <!-- /.box-header -->
		            <div class="box-body">
		              	<table id="pesquisa" class="table table-bordered table-hover">
			              <thead>
			                <tr>
			                  <th>Nome</th>
			                  <th class='text-center'>Permissões</th>
			                  <th class='text-center'>Opções</th>
			                </tr>
			                </thead>
			                <tbody>
								@foreach($users as $user)
									<tr>
										<td>{{ $user->name }}</td>
										<td class='text-center'>
										@if( ($roles = $user->roles()->get()) !== null )
											@foreach($roles as $role)
												<span class="label label-success">{{ $role->name }}</span>
											@endforeach
										@endif
											
										</td>
										<td class='text-center'>
											<a href="/editar-pesquisa/{{ $user->id }}" title='Editar'>
			                  					<i class="fa fa-edit"></i>
			                  				</a>
			                  				
			                  				&nbsp;&nbsp;
			                  				<a href="/detalhar-pesquisa/{{ $user->id }}" title='Visualizar'>
			                  					<i class="fa fa-eye"></i>
			                  				</a>

			                  				&nbsp;&nbsp;
											<a href="/delete/{{ $user->id }}" title='Apagar'>
			                  					<i class="fa fa-trash"></i>
			                  				</a>
			                  			</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
	@stop
	@section('js')
	<script type="text/javascript">
		jQuery('#pesquisa').DataTable({
			'dom': 'frt<"bottom" lp>',
	      	'paging'      : true,
	      	'lengthChange': false,
	      	'searching'   : true,
	      	'ordering'    : true,
	      	'info'        : true,
	      	'autoWidth'   : true,
	      	'columns' : [null,{'width':'10%'},{'width':'10%'}]
	    });
	</script>
	@stop
