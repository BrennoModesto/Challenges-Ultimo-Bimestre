<?php
// admin/produtos.php
require_once __DIR__ . '/../includes/auth.php';
exigir_admin();
require_once __DIR__ . '/../config/database.php';

$titulo_pagina = 'Produtos';
$produtos = $pdo->query('SELECT p.id, p.nome, p.preco, p.estoque, p.ativo, c.nome AS categoria
    FROM produtos p INNER JOIN categorias c ON c.id = p.categoria_id ORDER BY p.id')->fetchAll();

require_once __DIR__ . '/../includes/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Produtos</h1>
    <a href="produto_form.php" class="btn btn-terracota">Novo produto</a>
</div>
<div class="table-responsive">
    <table class="table table-hover align-middle tabela-kebab">
        <thead><tr><th>#</th><th>Nome</th><th>Categoria</th><th class="text-end">Preço</th><th class="text-center">Estoque</th><th>Status</th><th class="text-end">Ações</th></tr></thead>
        <tbody>
        <?php foreach ($produtos as $p): ?>
            <tr>
                <td><?= (int)$p['id'] ?></td>
                <td><?= e($p['nome']) ?></td>
                <td><?= e($p['categoria']) ?></td>
                <td class="text-end"><?= e(moeda($p['preco'])) ?></td>
                <td class="text-center"><?= (int)$p['estoque'] ?></td>
                <td><span class="badge bg-<?= $p['ativo'] ? 'success' : 'secondary' ?>"><?= $p['ativo'] ? 'Ativo' : 'Inativo' ?></span></td>
                <td class="text-end text-nowrap">
                    <a href="produto_form.php?id=<?= (int)$p['id'] ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                    <form method="post" action="produto_excluir.php" class="d-inline">
                        <?= csrf_campo() ?>
                        <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                        <input type="hidden" name="acao" value="<?= $p['ativo'] ? 'desativar' : 'ativar' ?>">
                        <button class="btn btn-sm btn-outline-warning"><?= $p['ativo'] ? 'Desativar' : 'Ativar' ?></button>
                    </form>
                    <form method="post" action="produto_excluir.php" class="d-inline" data-confirm="Excluir este produto?">
                        <?= csrf_campo() ?>
                        <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                        <input type="hidden" name="acao" value="excluir">
                        <button class="btn btn-sm btn-outline-danger">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
