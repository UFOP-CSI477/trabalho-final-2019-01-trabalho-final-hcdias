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
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                      @if(Session::has('success'))
                            <div class="col-md-6 col-md-offset-3">
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4><i class="icon fa fa-check"></i> Sucesso</h4>
                                    {{ Session::get('success') }}
                              </div>
                            </div>
                        @endif
                    </div>
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
                                        
                                        <span class="label label-success">{{ $user->group->roles->name }}</span>        
                                        </td>
                                        <td class='text-center'>
                                            <a href="/usuario/editar-usuario/{{ $user->id }}" title='Editar'>
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            

                                            &nbsp;&nbsp;
                                            <a href="/usuario/remover-usuario/{{ $user->id }}" title='Apagar'>
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
            'columns' : [null,{'width':'20%'},{'width':'10%'}]
        });
    </script>
    @stop
