<?php
require_once 'controllers/EventoController.php';
require_once 'controllers/AuthController.php';
require_once 'helpers/auth.php';
iniciarSessao();
$controlador = new EventoController();
$controladorAuth = new AuthController();
$acao = isset($_GET['acao']) ? $_GET['acao'] : 'listar';
switch ($acao) {
    case 'login':
        $controladorAuth->mostrarLogin();
        break;
    case 'autenticar':
        $controladorAuth->autenticar();
        break;
    case 'logout':
        $controladorAuth->logout();
        break;
    case 'criar':
        $controlador->criar();
        break;
    case 'salvar':
        $controlador->salvar();
        break;
    case 'editar':
        $controlador->editar();
        break;
    case 'atualizar':
        $controlador->atualizar();
        break;
    case 'excluir':
        $controlador->excluir();
        break;
    default:
        $controlador->listar();
        break;
}