<?php
// pedido_confirmado.php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/database.php';

exigir_login();
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$stmt = $pdo->prepare('SELECT id, data_pedido, forma_pagamento, total FROM pedidos WHERE id = :id AND usuario_id = :u');
$stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
$stmt->bindValue(':u', (int)$_SESSION['usuario_id'], PDO::PARAM_INT);
$stmt->execute();
$pedido = $stmt->fetch();
if (!$pedido) {
    flash_set('erro', 'Pedido não encontrado.');
    redirecionar('index.php');
}

$stmt = $pdo->prepare('SELECT pr.nome, ip.quantidade, ip.preco_unitario
    FROM itens_pedido ip INNER JOIN produtos pr ON pr.id = ip.produto_id
    WHERE ip.pedido_id = :id ORDER BY ip.id');
$stmt->bindValue(':id', (int)$pedido['id'], PDO::PARAM_INT);
$stmt->execute();
$itens = $stmt->fetchAll();
$formas = ['pix' => 'PIX', 'boleto' => 'Boleto', 'cartao' => 'Cartão de crédito'];

$titulo_pagina = 'Pedido confirmado';
require_once __DIR__ . '/includes/header.php';
?>
<div class="text-center mb-4">
    <div class="display-3">✅</div>
    <h1 class="h2">Pedido confirmado!</h1>
    <p class="text-muted">Obrigado pela compra, <?= e($_SESSION['usuario_nome']) ?>. Seu pedido já está sendo preparado.</p>
</div>
<div class="card card-form p-3 mx-auto" style="max-width:720px">
    <p class="mb-1"><strong>Pedido nº</strong> <?= (int)$pedido['id'] ?></p>
    <p class="mb-1"><strong>Data:</strong> <?= e(date('d/m/Y H:i', strtotime($pedido['data_pedido']))) ?></p>
    <p><strong>Pagamento:</strong> <?= e($formas[$pedido['forma_pagamento']] ?? $pedido['forma_pagamento']) ?></p>
    <div class="table-responsive">
        <table class="table table-hover tabela-kebab mb-0">
            <thead><tr><th>Produto</th><th class="text-center">Qtd</th><th class="text-end">Unitário</th><th class="text-end">Subtotal</th></tr></thead>
            <tbody>
            <?php foreach ($itens as $i): ?>
                <tr>
                    <td><?= e($i['nome']) ?></td>
                    <td class="text-center"><?= (int)$i['quantidade'] ?></td>
                    <td class="text-end"><?= e(moeda($i['preco_unitario'])) ?></td>
                    <td class="text-end"><?= e(moeda($i['quantidade'] * $i['preco_unitario'])) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot><tr><th colspan="3" class="text-end">Total</th><th class="text-end preco"><?= e(moeda($pedido['total'])) ?></th></tr></tfoot>
        </table>
    </div>
    <a href="index.php" class="btn btn-terracota mt-3">Voltar ao cardápio</a>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
