@extends('adminlte::page')

@section('content_header')
    <h1>Bem vindo, {{Auth::user()->name}}</h1>
    <small>Acompanhe sua movimentação recente de projetos</small>
@stop


@section('content')
  <div class="row">
    <div class="col-md-4">
      <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Trabalhos de conclusão de curso</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <canvas  id="chartTccs" width="400" height="400"></canvas>
          </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="box box-primary">
          <div class="box-header">
              <h3 class="box-title">Projetos de Pesquisa</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            
              <canvas  id="chartPesquisas" width="400" height="400"></canvas>
                         
          </div>
        </div>
    </div>

    <div class="col-md-4">
      <div class="box box-primary">
          <div class="box-header">
              <h3 class="box-title">Projetos de Extensão</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            
              <canvas  id="chartExtensoes" width="400" height="400"></canvas>
                         
          </div>
        </div>
    </div>    
  </div> 
  <div class="row">  
    <div class="col-md-4 col-md-offset-4">
      <div class="box box-primary">
          <div class="box-header">
              <h3 class="box-title">Teses de mestrado</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <canvas  id="chartMestrados" width="400" height="400"></canvas>
          </div>
      </div>
    </div>
  </div>  
  <input type="hidden" value="{{$pesquisas}}" id="pesquisasTotal"/>
  <input type="hidden" value="{{$tccs}}" id="tccsTotal"/>
  <input type="hidden" value="{{$extensoes}}" id="extensoesTotal"/>
  <input type="hidden" value="{{$mestrados}}" id="mestradosTotal"/>
@stop
@section('js')
<script src="https://cdnjs.com/libraries/Chart.js"></script>
<script type="text/javascript">
    var pesquisas = JSON.parse($("#pesquisasTotal").val());
    var tccs = JSON.parse($("#tccsTotal").val());
    var extensoes = JSON.parse($("#extensoesTotal").val());
    var mestrados = JSON.parse($("#mestradosTotal").val());

    var config = (alias) => {
      let dataConfig = [];
      let labelConfig = [];
      let colorsConfig = [];
      let colors = ['#07c5ff','#3c8dbc','#2038b1','#f39c12','#00a65a','#dd4b39'];

      Object.keys(alias).forEach((index)=>{
        dataConfig.push(alias[index].qtd);
        labelConfig.push(alias[index].desc);
        colorsConfig.push(colors[index-1]);
      });
      

      return  ({
          type: 'doughnut',
          data: {
            datasets: [{
              data: dataConfig,
              backgroundColor: colorsConfig,
              label: 'Demonstrativo'
            }],
            labels: labelConfig
          },
          options: {
            responsive: true,
            legend: {
              position: 'top',
            },
            title: {
              display: false,
              text: 'Visão geral dos projetos de pesquisa'
            },
            animation: {
              animateScale: true,
              animateRotate: true
            }
          }
        });
    };

    window.onload = function() {
      var ctxPesquisas = document.getElementById('chartPesquisas').getContext('2d');
      var ctxTccs = document.getElementById('chartTccs').getContext('2d');
      var ctxExtensoes = document.getElementById('chartExtensoes').getContext('2d');
      var ctxMestrados = document.getElementById('chartMestrados').getContext('2d');
      window.pesquisasGrafico = new Chart(ctxPesquisas, config(pesquisas));
      window.tccsGrafico = new Chart(ctxTccs, config(tccs));
      window.extensoesGrafico = new Chart(ctxExtensoes, config(extensoes));
      window.mestradosGrafico = new Chart(ctxMestrados, config(mestrados));

    };



       
</script>
@endsection