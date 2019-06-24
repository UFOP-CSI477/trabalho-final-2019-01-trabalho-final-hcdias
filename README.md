# UFOP-DEENP

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/74c2e067687b49a2a6ff882c653b1649)](https://app.codacy.com/app/hugo_root/ufop-deenp?utm_source=github.com&utm_medium=referral&utm_content=hcdias/ufop-deenp&utm_campaign=Badge_Grade_Dashboard)

[![CircleCI](https://circleci.com/gh/hcdias/ufop-deenp/tree/master.svg?style=svg)](https://circleci.com/gh/hcdias/ufop-deenp/tree/master)

Software para a gestão de projetos de pesquisa e trabalhos de conclusao de curso do Departamento de Engenharia de Produção da Universidade Federal de Ouro Preto

## Dependências para executar o projeto

- VirtualBox 5.2 || VMWare || Parallels || Hyper-V  
- Vagrant
- Composer
- PHP7

## Execução

Instale as dependencias do projeto utilizado o composer


Após instalar as dependências, execute o comando abaixo para gerar o Vagrantfile e o arquivo de configuração Homestead.yaml :

( **Linux**) php vendor/bin/homestead make

( **Windows**) vendor\\bin\\homestead make

Execute o comando **vagrant up** para  subir o ambiente. Acesse a vm com o comando **vagrant ssh** .
Navegue ao diretório **/vagrant** e execute os passos:
 - Gere as chaves do projeto com o comando **php artisan key:generate**
 
Em seguida execute as migrations e alimente o banco de dados com o comando **php artisan migrate:fresh --seed**
 
Acesse no navegador através do endereço:  http://localhost:8000.
