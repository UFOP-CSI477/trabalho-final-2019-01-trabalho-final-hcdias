# UFOP-DEENP
Software para a gestão de projetos de pesquisa e trabalhos de conclusao de curso do Departamento de Engenharia de Produção da Universidade Federal de Ouro Preto

## Dependências para executar o projeto

- VirtualBox 5.2 || VMWare || Parallels || Hyper-V  
- Vagrant


## Execução

Após instalar as dependências, execute o comando abaixo para gerar o Vagrantfile e o arquivo de configuração Homestead.yaml :

( **Linux**) php vendor/bin/homestead make

( **Windows**) vendor\\bin\\homestead make

Execute o comando **vagrant up** para  subir o ambiente. Acesse a vm com o comando **vagrant ssh** .
Navegue ao diretório **/vagrant** e execute os passos:
 - Gere as chaves do projeto com o comando **php artisan key:generate**
 
Em seguida execute as migrations e alimente o banco de dados com o comando **php artisan migrate:fresh --seed**
 
Acesse no navegador através do endereço:  http://localhost:8000.
