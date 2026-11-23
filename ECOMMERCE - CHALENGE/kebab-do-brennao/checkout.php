<?php
// checkout.php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/carrinho_funcs.php';

exigir_login('checkout');
carrinho_init();

if (!$_SESSION['carrinho']) {
    flash_set('aviso', 'Seu carrinho está vazio.');
    redirecionar('carrinho.php');
}

$formas = ['pix' => 'PIX', 'boleto' => 'Boleto', 'cartao' => 'Cartão de crédito'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    exigir_csrf('checkout.php');
    $forma = (string)($_POST['forma_pagamento'] ?? '');
    if (!isset($formas[$forma])) {
        flash_set('erro', 'Selecione uma forma de pagamento.');
        redirecionar('checkout.php');
    }

    try {
        $pdo->beginTransaction();
        $total = 0.0;
        $linhas = [];

        $sel = $pdo->prepare('SELECT id, nome, preco, estoque FROM produtos WHERE id = :id AND ativo = 1 FOR UPDATE');
        foreach ($_SESSION['carrinho'] as $pid => $qtd) {
            $sel->bindValue(':id', (int)$pid, PDO::PARAM_INT);
            $sel->execute();
            $p = $sel->fetch();
            if (!$p || (int)$p['estoque'] < (int)$qtd || (int)$qtd < 1) {
                throw new RuntimeException('Estoque insuficiente ou produto indisponível: ' . ($p['nome'] ?? 'item #' . (int)$pid) . '.');
            }
            $total += (float)$p['preco'] * (int)$qtd;
            $linhas[] = ['id' => (int)$p['id'], 'qtd' => (int)$qtd, 'preco' => $p['preco']];
        }

        $ins = $pdo->prepare('INSERT INTO pedidos (usuario_id, forma_pagamento, total) VALUES (:u, :f, :t)');
        $ins->bindValue(':u', (int)$_SESSION['usuario_id'], PDO::PARAM_INT);
        $ins->bindValue(':f', $forma, PDO::PARAM_STR);
        $ins->bindValue(':t', number_format($total, 2, '.', ''), PDO::PARAM_STR);
        $ins->execute();
        $pedido_id = (int)$pdo->lastInsertId();

        $insItem = $pdo->prepare('INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco_unitario) VALUES (:pe, :pr, :q, :pu)');
        $baixa   = $pdo->prepare('UPDATE produtos SET estoque = estoque - :q WHERE id = :id AND estoque >= :q2');
        foreach ($linhas as $l) {
            $insItem->bindValue(':pe', $pedido_id, PDO::PARAM_INT);
            $insItem->bindValue(':pr', $l['id'], PDO::PARAM_INT);
            $insItem->bindValue(':q', $l['qtd'], PDO::PARAM_INT);
            $insItem->bindValue(':pu', $l['preco'], PDO::PARAM_STR);
            $insItem->execute();

            $baixa->bindValue(':q', $l['qtd'], PDO::PARAM_INT);
            $baixa->bindValue(':id', $l['id'], PDO::PARAM_INT);
            $baixa->bindValue(':q2', $l['qtd'], PDO::PARAM_INT);
            $baixa->execute();
            if ($baixa->rowCount() !== 1) {
                throw new RuntimeException('Estoque insuficiente durante a finalização do pedido.');
            }
        }

        $pdo->commit();
        $_SESSION['carrinho'] = [];
        redirecionar('pedido_confirmado.php?id=' . $pedido_id);
    } catch (RuntimeException $ex) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        flash_set('erro', $ex->getMessage());
        redirecionar('carrinho.php');
    } catch (PDOException $ex) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        flash_set('erro', 'Não foi possível concluir o pedido. Tente novamente.');
        redirecionar('checkout.php');
    }
}

$titulo_pagina = 'Finalizar compra';
$itens = listar_itens($pdo);
if (!$itens) {
    redirecionar('carrinho.php');
}
$total = calcular_total($itens);
require_once __DIR__ . '/includes/header.php';
?>
<h1 class="h3 mb-4">Finalizar compra</h1>
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card card-form p-3">
            <h2 class="h5">Resumo do pedido</h2>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 tabela-kebab">
                    <thead><tr><th>Produto</th><th class="text-center">Qtd</th><th class="text-end">Subtotal</th></tr></thead>
                    <tbody>
                    <?php foreach ($itens as $i): ?>
                        <tr>
                            <td><?= e($i['nome']) ?></td>
                            <td class="text-center"><?= (int)$i['quantidade'] ?></td>
                            <td class="text-end"><?= e(moeda($i['subtotal'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot><tr><th colspan="2" class="text-end">Total</th><th class="text-end preco"><?= e(moeda($total)) ?></th></tr></tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <form method="post" action="checkout.php" class="card card-form p-3">
            <?= csrf_campo() ?>
            <h2 class="h5">Forma de pagamento</h2>
            <?php foreach ($formas as $valor => $rotulo): ?>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="forma_pagamento" id="pg-<?= e($valor) ?>" value="<?= e($valor) ?>" required>
                    <label class="form-check-label" for="pg-<?= e($valor) ?>"><?= e($rotulo) ?></label>
                </div>
            <?php endforeach; ?>
            <p class="small text-muted">Pagamento simulado: a confirmação é imediata.</p>
            <button type="submit" class="btn btn-terracota w-100">Confirmar pedido</button>
            <a href="carrinho.php" class="btn btn-link w-100">Voltar ao carrinho</a>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
