@extends('adminlte::page')
    @section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Proposta de TCC
        <small>gerenciar propostas</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Proposta de TCC</a></li>
        <li class="active">Busca</li>
      </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                    </div>
                    @if(Session::has('success'))
                        <div class="col-md-6 col-md-offset-3">
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-error"></i> Sucesso</h4>
                                {{ Session::get('success') }}
                          </div>
                        </div>
                    @elseif(Session::has('error'))
                        <div class="col-md-6 col-md-offset-3">
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-error"></i> Erro</h4>
                                {{ Session::get('error') }}
                          </div>
                        </div>
                    @endif
                    <div class="box-body">
                        <table id="tcc" class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Título</th>
                              <th class='text-center'>Status</th>
                              <th class='text-center'>Opções</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($propostas as $proposta)
                                    <tr>
                                        <td>{{ $proposta->titulo }}</td>
                                        <td class='text-center'>
                                            <span class="label alert-status-{{$proposta->status->id}}">{{$proposta->status->descricao}}</span>
                                        </td>
                                        <td class='text-center'>
                                            @can('aluno')
                                                <a href="/proposta-tcc/editar-proposta/{{$proposta->id}}" title='Editar'>
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endcan
                                                &nbsp;&nbsp;
                                                <a href="/proposta-tcc/detalhar-proposta/{{ $proposta->id }}" title='Editar'>
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            @can('aluno')
                                                &nbsp;&nbsp;
                                                <a href="{{route('deletar_proposta_tcc',$proposta)}}" title='Apagar'>
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            @endcan
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
        jQuery('#tcc').DataTable({
            'dom': 'frt<"bottom" lp>',
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true,
            'columns' : [null,{'width':'10%'},{'width':'20%'}]
        });
    </script>
    @stop
