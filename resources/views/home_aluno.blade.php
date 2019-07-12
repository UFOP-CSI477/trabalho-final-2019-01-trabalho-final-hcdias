@extends('adminlte::page')

@section('content_header')
    <h1>Bem vindo, {{Auth::user()->name}}</h1>
    <small>Acompanhe sua movimentação recente de projetos</small>
@stop


@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">Calendário de TCCs</h3>
          <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>

          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
        </div>
        <div class="box-body no-padding ">
          <div class="google-calendar responsive-calendar">
            <iframe src="https://calendar.google.com/calendar/embed?src=548rvo9tv5peavk3gqc3gosd6o%40group.calendar.google.com&ctz=America%2FSao_Paulo" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>

       
@stop