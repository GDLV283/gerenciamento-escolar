<?php
function iniciarSessao()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}
function usuarioEstaAutenticado()
{
    iniciarSessao();
    return isset($_SESSION['usuario']);
}
function obterUsuarioAutenticado()
{
    iniciarSessao();
    return $_SESSION['usuario'] ?? null;
}
function exigirAutenticacao()
{
    if (!usuarioEstaAutenticado()) {
        header('Location: index.php?acao=login&mensagem=Faça login para acessar esta área.&tipo=warning');
        exit;
    }
}
function gerarTokenCsrf()
{
    iniciarSessao();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}
function validarTokenCsrf($token)
{
    iniciarSessao();
    return isset($_SESSION['csrf_token']) && is_string($token) && hash_equals($_SESSION['csrf_token'], $token);
}
function exigirTokenCsrf($token)
{
    if (!validarTokenCsrf($token)) {
        header('Location: index.php?mensagem=Token de segurança inválido. Recarregue a página e tente novamente.&tipo=danger');
        exit;
    }
}
function montarSessaoUsuario(array $usuario)
{
    return [
        'id' => $usuario['id'],
        'nome' => $usuario['nome'],
        'email' => $usuario['email']
    ];
}
function registrarUsuarioNaSessao(array $usuario)
{
    iniciarSessao();
    session_regenerate_id(true);
    $_SESSION['usuario'] = $usuario;
}
function logoutUsuario()
{
    iniciarSessao();
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $parametros = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $parametros['path'],
            $parametros['domain'],
            $parametros['secure'],
            $parametros['httponly']
        );
    }
    session_destroy();
}