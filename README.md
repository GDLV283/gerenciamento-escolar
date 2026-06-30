# gerenciamento-escolar

Trabalho Final – Desenvolvimento Web com PHP Este projeto consiste em uma aplicação web desenvolvida em PHP utilizando o padrão MVC. O sistema funciona como uma agenda de compromissos e anotações, permitindo que cada usuário gerencie seus próprios eventos de forma segura através de autenticação com sessões.

Estrutura atual do projeto
index.php
    ponto de entrada e roteador simples por acao

assets/css
    style e temas para personalização do bootstrap
    
config/database.php
    configuração da conexão com o banco utilizando PDO
    
controllers/
    AuthController.php
       autenticação de usuários
    EventoController.php
       gerenciamento dos compromissos
       
models/
    Usuario.php
       acesso aos usuários
    Evento.php
       operações do CRUD de compromissos
       
helpers/auth.php
    controle de sessões e autenticação
    
uploads
    pasta para upload de imagens
views/
    auth/login.php
      tela de login
    eventos/formulario.php e eventos/lista.php
      listagem e formulário de compromissos
    layout/footer.php e layout/header.php 
      cabeçalho e rodapé compartilhados

Estrutura atual do projeto

O sistema permite:
  - Login e logout utilizando sessões PHP
  - Cadastro de compromissos
  - Edição de compromissos
  - Exclusão de compromissos
  - Upload de imagens para os compromissos
  - Organização dos compromissos por data
  - Destaque automático dos quatro compromissos mais importantes
  - Cada usuário visualiza apenas seus próprios compromissos
  - Proteção contra acesso não autorizado

Autenticação do projeto

A autenticação implementada realiza:
  - início da sessão com `session_start()`
  - armazenamento do usuário autenticado em `$_SESSION`
  - controle de acesso às páginas restritas
  - isolamento dos compromissos por usuário
  - validação de formulários com Token CSRF
  - encerramento seguro da sessão através do logout

Credenciais de demonstração

Usuario 1
E-mail: usuario@exemplo.com
Senha: 123456

Usuario 2
E-mail: gabylimavieira06@gmail.com
Senha: 123456     

Como usar

Abrir XAMPP e ativar Apache e MySQL
Abrir http://localhost, acessar phpMyAdmin e seguida clicar em SQL   
Importar database/eventos.sql ou acessar Script SQL
Colocar SQL e executar
Abrir http://localhost/gerenciamento-escolar/
Fazer login com as credenciais de demonstração


