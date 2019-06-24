@extends('adminlte::page')

@section('content_header')
    <h1>Bem vindo, {{Auth::user()->name}}</h1>
    <small>Acopanhe sua movimentação recente de projetos</small>
@stop


@section('content')
	<section class="content">
      <div class="error-page">
        <h2 class="headline text-yellow"> 403</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops! Parece que você não pode realizar essa ação..</h3>

        @if(isset($error_message))
          <p>{{ $error_message }}</p>
        @else
          <p>
            Não foi possível encontrar o que você está procurando.
            Volte ao dashboard para visualizar seus projetos.
          </p>
        @endif
          

          <!-- <form class="search-form">
            <div class="input-group">
              <input type="text" name="search" class="form-control" placeholder="Search">

              <div class="input-group-btn">
                <button type="submit" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i>
                </button>
              </div>
            </div>
            <!-- /.input-group -->
          <!-- </form>  -->
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
    @stop