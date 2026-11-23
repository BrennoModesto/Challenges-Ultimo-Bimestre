<?php
// carrinho.php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/carrinho_funcs.php';

carrinho_init();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    exigir_csrf('carrinho.php');
    $acao = (string)($_POST['acao'] ?? '');
    $id   = (int)($_POST['id'] ?? 0);

    if ($acao === 'adicionar') {
        [$ok, $msg] = adicionar($pdo, $id, (int)($_POST['quantidade'] ?? 1));
        flash_set($ok ? 'sucesso' : 'erro', $msg);
        redirecionar($ok ? 'carrinho.php' : 'produto.php?id=' . $id);
    } elseif ($acao === 'atualizar') {
        $houve_erro = false;
        foreach ((array)($_POST['qtd'] ?? []) as $pid => $q) {
            [$ok, $msg] = alterar_quantidade($pdo, (int)$pid, (int)$q);
            if (!$ok) {
                $houve_erro = true;
                flash_set('erro', $msg);
            }
        }
        if (!$houve_erro) {
            flash_set('sucesso', 'Carrinho atualizado.');
        }
    } elseif ($acao === 'remover') {
        remover($id);
        flash_set('sucesso', 'Item removido do carrinho.');
    }
    redirecionar('carrinho.php');
}

$titulo_pagina = 'Carrinho';
$itens = listar_itens($pdo);
$total = calcular_total($itens);
require_once __DIR__ . '/includes/header.php';
?>
<h1 class="h3 mb-4">Seu carrinho</h1>
<?php if (!$itens): ?>
    <div class="alert alert-info">
        Seu carrinho está vazio. <a href="index.php" class="alert-link">Voltar ao cardápio</a>
    </div>
<?php else: ?>
<form method="post" action="carrinho.php" id="form-carrinho">
    <?= csrf_campo() ?>
    <input type="hidden" name="acao" value="atualizar">
    <div class="table-responsive">
        <table class="table table-hover align-middle tabela-kebab">
            <thead>
                <tr><th>Produto</th><th class="text-end">Preço unit.</th><th style="width:130px">Quantidade</th><th class="text-end">Subtotal</th><th></th></tr>
            </thead>
            <tbody>
            <?php foreach ($itens as $i): ?>
                <tr>
                    <td><a href="produto.php?id=<?= (int)$i['id'] ?>" class="fw-semibold"><?= e($i['nome']) ?></a></td>
                    <td class="text-end"><?= e(moeda($i['preco'])) ?></td>
                    <td>
                        <input type="number" class="form-control form-control-sm" name="qtd[<?= (int)$i['id'] ?>]"
                               value="<?= (int)$i['quantidade'] ?>" min="1" max="<?= (int)$i['estoque'] ?>" required>
                    </td>
                    <td class="text-end"><?= e(moeda($i['subtotal'])) ?></td>
                    <td class="text-end">
                        <button type="submit" form="form-remover-<?= (int)$i['id'] ?>" class="btn btn-sm btn-outline-danger">Remover</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr><th colspan="3" class="text-end">Total geral</th><th class="text-end preco"><?= e(moeda($total)) ?></th><th></th></tr>
            </tfoot>
        </table>
    </div>
    <div class="d-flex flex-wrap gap-2 justify-content-between">
        <a href="index.php" class="btn btn-outline-secondary">Continuar comprando</a>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-outline-terracota">Atualizar quantidades</button>
            <a href="checkout.php" class="btn btn-terracota">Finalizar compra</a>
        </div>
    </div>
</form>
<?php foreach ($itens as $i): ?>
    <form method="post" action="carrinho.php" id="form-remover-<?= (int)$i['id'] ?>" class="d-none">
        <?= csrf_campo() ?>
        <input type="hidden" name="acao" value="remover">
        <input type="hidden" name="id" value="<?= (int)$i['id'] ?>">
    </form>
<?php endforeach; ?>
<?php endif; ?>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
