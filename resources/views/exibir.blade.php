<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" href="favicon.ico">
    
    <title>Consulta de Projetos e Orientações</title>
    
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
    
  </head>
  
  <body class="bg-light">

<!-- Start Navbar -->

    <nav class="navbar navbar-dark bg-dark">
      <a class="navbar-brand" href="#">OPÇÕES DE CONSULTA</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample01" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExample01">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Projetos de Iniciação Científica <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Trabalhos de Conclusão de Curso</a>
          </li>
        </ul>
      </div>
    </nav>

<!-- End Navbar -->

  <br>
    <div class="container">
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="http://www.sisbin.ufop.br/evento/images/ufop.gif" alt="" width="100">
        <h2>Projetos de Iniciação Científica</h2>
        <p class="lead">Projetos de Iniciação Científica cadastrados e ativos no Departamento de Engenharia de Produção no Instituto de Ciências Exatas e Aplicadas da Universidade Federal de Ouro Preto</p>
      </div>
    </div>

    <div class="col-md-12 order-md-1">
      <hr class="mb-4">
        <h4 class="mb-3">Filtros de Pesquisa</h4>

      <div class="row">

          <div class="col-md-3 mb-3">
              <label for="firstName">Professor orientador</label>
                <select class="custom-select d-block w-100" id="country" required>
                  <option value="">Todos...</option>
                    <option>Marco Antonio Bonelli Junior</option>
            <option>Mônica do Amaral</option>
            <option>Thiago Augusto de Oliveira Silva</option>
                </select>
              <div class="invalid-feedback">
                  Favor informar professor válido.
            </div>
            </div>

          <div class="col-md-3 mb-3">
              <label for="firstName">Status do projeto</label>
                <select class="custom-select d-block w-100" id="country" required>
                  <option value="">Todos...</option>
                    <option>Em concepção</option>
            <option>Em desenvolvimento</option>
            <option>Em geração de resultados</option>
                </select>
              <div class="invalid-feedback">
                  Favor informar status válido.
            </div>
            </div>

          <div class="col-md-3 mb-3">
              <label for="firstName">Área de conhecimento</label>
                <select class="custom-select d-block w-100" id="country" required>
                  <option value="">Todos...</option>
                    <option>Logística e cadeia de suprimentos</option>
            <option>Pesquisa operacional</option>
            <option>Planejamento e controle da produção</option>
                </select>
              <div class="invalid-feedback">
                  Favor informar área válida.
            </div>
            </div>

          <div class="col-md-3 mb-3">
              <label for="firstName">Abordagem de pesquisa</label>
                <select class="custom-select d-block w-100" id="country" required>
                  <option value="">Todos...</option>
                    <option>Quantitativo</option>
            <option>Qualitativo</option>
                </select>
              <div class="invalid-feedback">
                  Favor informar abordagem válida.
            </div>
            </div>

      </div>

      <hr class="mb-4">

      <div id="accordion">
        <br>

        <?php

          $conexao = new PDO("mysql:host=localhost;dbname=homestead", "homestead", "secret"); 
        
          $query = "SELECT  a.*, b.*,c.*,d.descricao as natureza,e.descricao as abordagem,f.descricao as objetivo FROM pesquisas a 
          join vinculo_pesquisas b ON a.id = b.pesquisa_id 
          join professores c ON b.professor_id = c.id 
          join natureza_pesquisas d on a.natureza_pesquisa_id = d.id
          join abordagem_pesquisas e on a.abordagem_pesquisa_id = e.id
          join objetivo_pesquisas f on a.objetivo_pesquisa_id = f.id
          where b.professor_papel_id = 1
          group by b.pesquisa_id";
      
          $statement = $conexao->prepare($query);
          $statement->execute();
          $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
          // dd($result);die;
          foreach($result as $res){
        
            $tabela = '<div class="card">';
            $tabela .= '<div class="card-header" id="heading' . $res['pesquisa_id'] . '">';
            $tabela .= '<h5 class "mb-0">';
            $tabela .= '<button class="btn btn-link text-dark" color="red" data-toggle="collapse" data-target="#collapse' . $res['pesquisa_id'] . '" aria-expanded="false" aria-controls="collapse' . $res['pesquisa_id'] . '">';
            $tabela .= utf8_encode($res['pesquisa_titulo']);
            $tabela .= '</button>';
            $tabela .= '</h5>';
            $tabela .= '</div>';
            $tabela .= '<div id="collapse' . $res['pesquisa_id'] . '" class="collapse" aria-labelledby="heading' . $res['pesquisa_id'] . '" data-parent="#accordion">';
            $tabela .= '<div class="card-body">' . 
                        '<b>Nome do professor:</b> ' . $res['professor_nome'] . '<br>' .
                        '<b>Quantidade de alunos:</b> -- <br>' .
                        '<hr class="mb-4">' .
                        '<b>Natureza da pesquisa:</b> ' . utf8_encode($res['natureza']) . '<br>' .
                        '<b>Abordagem da pesquisa:</b> ' . $res['abordagem'] . '<br>' .
                        '<b>Objetivo da pesquisa:</b> ' . $res['objetivo'] . '<br>' .
                        '<hr class="mb-4">' .
                        '<b>Inicio do trabalho:</b> ' . $res['pesquisa_semestre_inicio'] . ' de ' . $res['pesquisa_ano_inicio'] . '<br>' .
                        '<b>Status de desenvolvimento:</b> ' . $res['pesquisa_status'] . '<br>' .
                        '<hr class="mb-4">' .
                        '<b>Resumo do projeto:</b> ' . utf8_encode($res['pesquisa_resumo']) . '<br>' .
                        '</div>';
            $tabela .= '</div>';
            $tabela .= '</div>';
    
            echo $tabela . '<br>';
          }
        ?>
    
    <!-- <p><strong>Note:</strong> The <strong>data-parent</strong> attribute makes sure that all collapsible elements under the specified parent will be closed when one of the collapsible item is shown.</p> <!-- -->
    
      </div> 
  
      <div>
        <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2017-2018 Universidade Federal de Ouro Preto</p>
        <ul class="list-inline">
          <li class="list-inline-item"><a href="#">Privacidade</a></li>
          <li class="list-inline-item"><a href="#">Termos</a></li>
          <li class="list-inline-item"><a href="#">Suporte</a></li>
        </ul>
        </footer>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="bootstrap/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="assets/js/vendor/popper.min.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
    <script src="assets/js/vendor/holder.min.js"></script>
    <script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function() {
        'use strict';

        window.addEventListener('load', function() {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');

          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();
    </script>
  </body>
</html>
