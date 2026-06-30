<?php require 'views/layout/header.php'; ?>
<?php $usuarioAutenticado = usuarioEstaAutenticado(); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">⚠️ Atenção! ⚠️</h1>
        <p class="text-muted mb-0">Os primeiros 4 compromissos mais IMPORTANTES.</p>
    </div>
    <?php if ($usuarioAutenticado) : ?>
        <a href="index.php?acao=criar" class="btn btn-success">Novo compromisso</a>
    <?php else : ?>
        <a href="index.php?acao=login" class="btn btn-outline-success">Fazer login</a>
    <?php endif; ?>
</div>
<?php if (!empty($mensagem)) : ?>
    <div class="alert alert-<?php echo htmlspecialchars($tipoMensagem); ?>">
        <?php echo htmlspecialchars($mensagem); ?>
    </div>
<?php endif; ?>
<div class="row g-3 mb-4">
<?php if(isset($eventosProximos) && !empty($eventosProximos)): ?>
    <?php foreach ($eventosProximos as $evento): ?>
    <div class="col-md-6 col-lg-3">
        <div class="card h-100 shadow-sm border-<?php echo $classe; ?>">
            <?php if(!empty($evento['imagem'])): ?>
            <img src="<?= htmlspecialchars($evento['imagem']) ?>" class="card-img-top"style="height:200px;object-fit:cover;" >
            <?php endif; ?>
            <div class="card-header bg-<?php echo $classe; ?> text-white">
                <strong><?= htmlspecialchars($evento['status_evento']) ?></strong>
            </div>
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($evento['nome']) ?></h5>
                <p class="text-muted"><?= date('d/m/Y', strtotime($evento['data_compromisso'])) ?></p>
                <p><?= htmlspecialchars(substr($evento['observacoes'],0,80)) ?></p>
                <?php
                    $corBadge = match ($evento['status_evento']) {
                        'Pendente' => 'primary',
                        'Em andamento' => 'warning',
                        'Concluído' => 'success',
                        'IMPORTANTE' => 'danger',
                        default => 'secondary'
                    };
                ?>
                <span class="badge bg-<?= $corBadge ?>">
                    <?= htmlspecialchars($evento['status_evento']) ?>
                </span>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>
</div>
<br>
<p>✎﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏༄˖°.☕️.ೃ࿔📚*:･✎﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏﹏</p>
<br>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Tabela de compromissos</h1>
        <p class="text-muted mb-0">Todos os compromissos/anotações criados. Você pode editar a qualquer momento! ദ്ദി(ᵔᗜᵔ)</p>
    </div>
    <?php if ($usuarioAutenticado) : ?>
        <a href="index.php?acao=criar" class="btn btn-success">Novo compromisso</a>
    <?php else : ?>
        <a href="index.php?acao=login" class="btn btn-outline-success">Fazer login</a>
    <?php endif; ?>
</div>
<?php if (!empty($mensagem)) : ?>
    <div class="alert alert-<?php echo htmlspecialchars($tipoMensagem); ?>">
        <?php echo htmlspecialchars($mensagem); ?>
    </div>
<?php endif; ?>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Compromissos</th>
                        <th>Local</th>
                        <th>Data</th>
                        <th>Hórario</th>
                        <th>Status</th>
                        <th>Anotação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($eventos)) : ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                Nenhum compromisso cadastrado até agora.
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($eventos as $evento) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($evento['id']); ?></td>
                                <td><?php echo htmlspecialchars($evento['nome']); ?></td>
                                <td><?php echo htmlspecialchars($evento['local_compromisso']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($evento['data_compromisso'])); ?></td>
                                <td><?php echo htmlspecialchars($evento['horario']); ?></td>
                                <td><?php
                                    $corBadge = match ($evento['status_evento']) {
                                        'Pendente' => 'primary',
                                        'Em andamento' => 'warning',
                                        'Concluído' => 'success',
                                        'IMPORTANTE' => 'danger',
                                        default => 'secondary'
                                        };
                                    ?>
                                    <span class="badge bg-<?php echo $corBadge; ?>">
                                <?php echo htmlspecialchars($evento['status_evento']); ?></span>
                                </td>
                                <td><?php echo htmlspecialchars($evento['observacoes']); ?></td>
                                <td class="text-center">
                                    <?php if ($usuarioAutenticado) : ?>
                                        <a href="index.php?acao=editar&id=<?php echo $evento['id']; ?>" class="btn btn-sm btn-outline-primary">
                                            Editar
                                        </a>
                                        <form action="index.php?acao=excluir" method="POST" class="d-inline">
                                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($evento['id']); ?>">
                                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(gerarTokenCsrf()); ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Deseja realmente excluir este evento?');">
                                                Excluir
                                            </button>
                                        </form>
                                    <?php else : ?>
                                        <span class="badge text-bg-secondary">Login necessário</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require 'views/layout/footer.php'; ?>