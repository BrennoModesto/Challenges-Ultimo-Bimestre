<?php
// admin/pedidos.php
require_once __DIR__ . '/../includes/auth.php';
exigir_admin();
require_once __DIR__ . '/../config/database.php';

$titulo_pagina = 'Pedidos';
$linhas = $pdo->query('SELECT pe.id, pe.data_pedido, pe.forma_pagamento, pe.total, u.nome AS cliente, u.email,
        pr.nome AS produto, ip.quantidade, ip.preco_unitario
    FROM pedidos pe
    INNER JOIN usuarios u ON u.id = pe.usuario_id
    INNER JOIN itens_pedido ip ON ip.pedido_id = pe.id
    INNER JOIN produtos pr ON pr.id = ip.produto_id
    ORDER BY pe.id DESC, ip.id')->fetchAll();

$pedidos = [];
foreach ($linhas as $l) {
    $pedidos[$l['id']]['dados'] = $l;
    $pedidos[$l['id']]['itens'][] = $l;
}
$formas = ['pix' => 'PIX', 'boleto' => 'Boleto', 'cartao' => 'Cartão'];

require_once __DIR__ . '/../includes/header.php';
?>
<h1 class="h3 mb-4">Pedidos realizados</h1>
<?php if (!$pedidos): ?>
    <div class="alert alert-info">Nenhum pedido realizado até o momento.</div>
<?php else: ?>
<div class="table-responsive">
    <table class="table table-hover align-middle tabela-kebab">
        <thead><tr><th>#</th><th>Cliente</th><th>Data</th><th>Pagamento</th><th>Itens</th><th class="text-end">Total</th></tr></thead>
        <tbody>
        <?php foreach ($pedidos as $pid => $ped): $d = $ped['dados']; ?>
            <tr>
                <td><?= (int)$pid ?></td>
                <td><?= e($d['cliente']) ?><br><small class="text-muted"><?= e($d['email']) ?></small></td>
                <td><?= e(date('d/m/Y H:i', strtotime($d['data_pedido']))) ?></td>
                <td><span class="badge badge-categoria"><?= e($formas[$d['forma_pagamento']] ?? $d['forma_pagamento']) ?></span></td>
                <td>
                    <ul class="list-unstyled mb-0 small">
                    <?php foreach ($ped['itens'] as $i): ?>
                        <li><?= (int)$i['quantidade'] ?>× <?= e($i['produto']) ?> — <?= e(moeda($i['preco_unitario'])) ?></li>
                    <?php endforeach; ?>
                    </ul>
                </td>
                <td class="text-end fw-bold"><?= e(moeda($d['total'])) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
