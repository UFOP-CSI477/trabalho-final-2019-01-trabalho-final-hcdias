# **CSI477-2019-01 - Proposta de Trabalho Final**
## *Grupo: Hugo Carvalho*

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/74c2e067687b49a2a6ff882c653b1649)](https://app.codacy.com/app/hugo_root/ufop-deenp?utm_source=github.com&utm_medium=referral&utm_content=hcdias/ufop-deenp&utm_campaign=Badge_Grade_Dashboard)
[![CircleCI](https://circleci.com/gh/hcdias/ufop-deenp/tree/master.svg?style=svg)](https://circleci.com/gh/hcdias/ufop-deenp/tree/master)
--------------

<!-- Descrever um resumo sobre o trabalho. -->

### Resumo
O objetivo deste documento é apresentar uma proposta para o trabalho a ser desenvolvido na disciplina CSI477 -- Sistemas WEB I. É uma breve descrição sobre o tema que será abordado, bem como o escopo, as restrições e demais questões pertinentes ao trabalho. 

<!-- Apresentar o tema. -->
### 1. Tema

  O trabalho final tem como tema o desenvolvimento de um software para gerenciamento de propostas de TCC. Através do software será possível para alunos visualizarem as áreas de atuação dos docentes, selecionar um docente para orientação, escrever uma proposta de trabalho de conclusão de curso e solicitar a aprovação da proposta.

<!-- Descrever e limitar o escopo da aplicação. -->
### 2. Escopo

  Este projeto terá as seguintes funcionalidades:
  - Login via *MinhaUfop* para acesso de alunos e professores;
  - Painel administrativo para a elaboração de propostas de trabalho de conclusão de curso, acessível para alunos da universidade. O painel deve contar com:
  	- Professores disponíveis para orientação;
  	- Área de atuação dos professores;
  	- Temas de interesse dos professores;
  	- Propostas já enviadas e seus status(aprovado ou reprovado)

  - Painel administrativo para análise das propostas de trabalho de conclusão de curso, acessível para professores da universidade. O painel deve contar com:
  	- Solicitações de orientação;
  	- Propostas aprovadas ou reprovadas;
  

<!-- Apresentar restrições de funcionalidades e de escopo. -->
### 3. Restrições

  Este trabalho não possui restrições. 

<!-- Construir alguns protótipos para a aplicação, disponibilizá-los no Github e descrever o que foi considerado. //-->
### 4. Protótipo
  Em andamento.

### 5. Referências
  Em andamento.

## 6. Dependências para executar o projeto

- VirtualBox 5.2 || VMWare || Parallels || Hyper-V  
- Vagrant
- Composer
- PHP7

## 7. Execução

Instale as dependencias do projeto utilizado o composer


Após instalar as dependências, execute o comando abaixo para gerar o Vagrantfile e o arquivo de configuração Homestead.yaml :

( **Linux**) php vendor/bin/homestead make

( **Windows**) vendor\\bin\\homestead make

Execute o comando **vagrant up** para  subir o ambiente. Acesse a vm com o comando **vagrant ssh** .
Navegue ao diretório **/vagrant** e execute os passos:
 - Gere as chaves do projeto com o comando **php artisan key:generate**
 
Em seguida execute as migrations e alimente o banco de dados com o comando **php artisan migrate:fresh --seed**
 
Acesse no navegador através do endereço:  http://localhost:8000.
