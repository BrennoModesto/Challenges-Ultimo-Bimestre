<?php
// admin/index.php
require_once __DIR__ . '/../includes/auth.php';
exigir_admin();
require_once __DIR__ . '/../config/database.php';

$titulo_pagina = 'Painel administrativo';
$total_produtos = (int)$pdo->query('SELECT COUNT(*) FROM produtos')->fetchColumn();
$total_pedidos  = (int)$pdo->query('SELECT COUNT(*) FROM pedidos')->fetchColumn();
$total_clientes = (int)$pdo->query("SELECT COUNT(*) FROM usuarios WHERE perfil = 'cliente'")->fetchColumn();
$receita        = (float)$pdo->query('SELECT COALESCE(SUM(total), 0) FROM pedidos')->fetchColumn();

require_once __DIR__ . '/../includes/header.php';
?>
<h1 class="h3 mb-4">Painel administrativo</h1>
<div class="row g-3 mb-4">
    <?php
    $cards = [
        ['Produtos', $total_produtos],
        ['Pedidos', $total_pedidos],
        ['Clientes', $total_clientes],
        ['Receita total', moeda($receita)],
    ];
    foreach ($cards as [$rotulo, $valor]): ?>
        <div class="col-6 col-lg-3">
            <div class="card card-stat p-3 text-center">
                <div class="small text-uppercase text-muted"><?= e($rotulo) ?></div>
                <div class="fs-3 fw-bold preco"><?= e($valor) ?></div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div class="d-flex flex-wrap gap-2">
    <a href="produtos.php" class="btn btn-terracota">Gerenciar produtos</a>
    <a href="produto_form.php" class="btn btn-outline-terracota">Novo produto</a>
    <a href="pedidos.php" class="btn btn-outline-terracota">Ver pedidos</a>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
