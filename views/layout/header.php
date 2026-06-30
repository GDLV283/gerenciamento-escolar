<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda ヾ(＾ ∇├┬┴┬┴</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <?php $usuarioAutenticado = obterUsuarioAutenticado(); ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">✎𓂃Agenda 𓍢ִ໋☕️✧˚ ༘ ⋆</a>
            <div class="d-flex align-items-center gap-2">
                <a class="btn btn-sm btn-outline-light" href="index.php">Compromissos</a>
                <?php if ($usuarioAutenticado) : ?>
                    <span class="navbar-text text-white">
                        <?php echo htmlspecialchars($usuarioAutenticado['nome']); ?>
                    </span>
                    <form action="index.php?acao=logout" method="POST" class="m-0">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(gerarTokenCsrf()); ?>">
                        <button type="submit" class="btn btn-sm btn-light">Sair</button>
                    </form>
                <?php else : ?>
                    <a class="btn btn-sm btn-light" href="index.php?acao=login">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <main class="container py-4">