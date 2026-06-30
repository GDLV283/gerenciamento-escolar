<?php require 'views/layout/header.php'; ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-1"><?php echo $tituloPagina; ?></h1>
                        <p class="text-muted mb-0">Preencha os dados do compromisso.</p>
                    </div>
                    <a href="index.php" class="btn btn-outline-secondary">Voltar</a>
                </div>
                <form action="index.php?acao=<?php echo $acaoFormulario; ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(gerarTokenCsrf()); ?>">

                    <?php if ($acaoFormulario === 'atualizar') : ?>
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($evento['id']); ?>">
                    <?php endif; ?>
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome do compromisso</label>
                        <input
                            type="text"
                            class="form-control"
                            id="nome"
                            name="nome"
                            value="<?php echo htmlspecialchars($evento['nome']); ?>"
                            required
                        >
                    </div>
                    <div class="mb-3">
                        <label for="local_compromisso" class="form-label">Local</label>
                        <input
                            type="text"
                            class="form-control"
                            id="local_compromisso"
                            name="local_compromisso"
                            value="<?php echo htmlspecialchars($evento['local_compromisso']); ?>"
                            required
                        >
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="data_compromisso" class="form-label">Data</label>
                            <input
                                type="date"
                                class="form-control"
                                id="data_compromisso"
                                name="data_compromisso"
                                value="<?php echo htmlspecialchars($evento['data_compromisso']); ?>"
                                required
                            >
                        </div>
                                 <div class="col-md-4 mb-3">
                            <label for="horario" class="form-label">Horário</label>
                            <input
                                type="time"
                                class="form-control"
                                id="horario"
                                name="horario"
                                value="<?php echo htmlspecialchars($evento['horario']); ?>"
                                required
                            >
                        </div>               
                        <div class="col-md-4 mb-3">
                            <label for="status_evento" class="form-label">Status</label>
                            <select class="form-select" id="status_evento" name="status_evento" required>
                                <option value="">Selecione</option>
                                <option value="Pendente" <?php echo $evento['status_evento'] === 'Pendente' ? 'selected' : ''; ?>>Pendente</option>
                                <option value="Em andamento" <?php echo $evento['status_evento'] === 'Em andamento' ? 'selected' : ''; ?>>Em andamento</option>
                                <option value="Concluído" <?php echo $evento['status_evento'] === 'Concluído' ? 'selected' : ''; ?>>Concluído</option>
                                <option value="IMPORTANTE" <?php echo $evento['status_evento'] === 'IMPORTANTE' ? 'selected' : ''; ?>>IMPORTANTE</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="observacoes" class="form-label">Anotações</label>
                        <textarea
                            class="form-control"
                            id="observacoes"
                            name="observacoes"
                            rows="4"
                        ><?php echo htmlspecialchars($evento['observacoes']); ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="imagem" class="form-label">Imagem do evento</label>
                            <input
                                type="file"
                                class="form-control"
                                id="imagem"
                                name="imagem"       
                            >
                    </div>
                    <button type="submit" class="btn btn-success">Salvar</button>
                    <a href="index.php" class="btn btn-outline-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require 'views/layout/footer.php'; ?>