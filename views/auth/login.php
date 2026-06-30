<?php require 'views/layout/header.php'; ?>
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h1 class="h3 mb-1">Login</h1>
                    <p class="text-muted mb-0">Faça o login na conta que deseja.</p>
                </div>
                <?php if (!empty($mensagem)) : ?>
                    <div class="alert alert-<?php echo htmlspecialchars($tipoMensagem); ?>">
                        <?php echo htmlspecialchars($mensagem); ?>
                    </div>
                <?php endif; ?>
                <form action="index.php?acao=autenticar" method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(gerarTokenCsrf()); ?>">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require 'views/layout/footer.php'; ?>