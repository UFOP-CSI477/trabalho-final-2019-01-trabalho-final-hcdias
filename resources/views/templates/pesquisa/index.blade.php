@extends('adminlte::page')
	@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Projetos de Pesquisa
        <small>pesquisar projetos</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Projetos de pesquisas</a></li>
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
			                  <th>Título</th>
			                  <th class='text-center'>Status</th>
			                  <th class='text-center'>Opções</th>
			                </tr>
			                </thead>
			                <tbody>
								@foreach($pesquisas as $pesquisa)
									<tr>
										<td>{{ $pesquisa->pesquisa_titulo }}</td>
										<td class='text-center'>
											<span class="label label-success">Publicado</span>
										</td>
										<td class='text-center'>
											<a href="/edit/{{ $pesquisa->id }}" title='Editar'>
			                  					<i class="fa fa-edit"></i>
			                  				</a>
			                  				
			                  				&nbsp;&nbsp;
			                  				<a href="/view/{{ $pesquisa->id }}" title='Visualizar'>
			                  					<i class="fa fa-eye"></i>
			                  				</a>

			                  				&nbsp;&nbsp;
											<a href="/delete/{{ $pesquisa->id }}" title='Apagar'>
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