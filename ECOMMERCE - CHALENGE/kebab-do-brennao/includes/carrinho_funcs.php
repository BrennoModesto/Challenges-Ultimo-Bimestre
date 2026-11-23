<?php
// includes/carrinho_funcs.php

function carrinho_init(): void
{
    if (!isset($_SESSION['carrinho']) || !is_array($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }
}

function buscar_produto_ativo(PDO $pdo, int $id): ?array
{
    $stmt = $pdo->prepare('SELECT id, nome, preco, estoque FROM produtos WHERE id = :id AND ativo = 1');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $p = $stmt->fetch();
    return $p ?: null;
}

/** Retorna [bool ok, string mensagem] */
function adicionar(PDO $pdo, int $id, int $qtd): array
{
    carrinho_init();
    if ($qtd < 1) {
        return [false, 'Quantidade inválida.'];
    }
    $p = buscar_produto_ativo($pdo, $id);
    if (!$p) {
        return [false, 'Produto não encontrado.'];
    }
    $nova = ($_SESSION['carrinho'][$id] ?? 0) + $qtd;
    if ($p['estoque'] < 1) {
        return [false, 'Produto esgotado.'];
    }
    if ($nova > $p['estoque']) {
        return [false, 'Quantidade excede o estoque disponível (' . $p['estoque'] . ').'];
    }
    $_SESSION['carrinho'][$id] = $nova;
    return [true, '"' . $p['nome'] . '" adicionado ao carrinho.'];
}

function alterar_quantidade(PDO $pdo, int $id, int $qtd): array
{
    carrinho_init();
    if (!isset($_SESSION['carrinho'][$id])) {
        return [false, 'Item não está no carrinho.'];
    }
    if ($qtd < 1) {
        remover($id);
        return [true, 'Item removido do carrinho.'];
    }
    $p = buscar_produto_ativo($pdo, $id);
    if (!$p) {
        remover($id);
        return [false, 'Produto indisponível e removido do carrinho.'];
    }
    if ($qtd > $p['estoque']) {
        $_SESSION['carrinho'][$id] = max(1, (int)$p['estoque']);
        return [false, 'Quantidade ajustada ao estoque disponível (' . $p['estoque'] . ') para "' . $p['nome'] . '".'];
    }
    $_SESSION['carrinho'][$id] = $qtd;
    return [true, 'Quantidade atualizada.'];
}

function remover(int $id): void
{
    carrinho_init();
    unset($_SESSION['carrinho'][$id]);
}

/** Lista itens do carrinho com dados atuais do banco. */
function listar_itens(PDO $pdo): array
{
    carrinho_init();
    $ids = array_map('intval', array_keys($_SESSION['carrinho']));
    if (!$ids) {
        return [];
    }
    $marcadores = [];
    foreach ($ids as $i => $_) {
        $marcadores[] = ':id' . $i;
    }
    $stmt = $pdo->prepare('SELECT id, nome, preco, estoque, imagem, ativo FROM produtos WHERE id IN (' . implode(',', $marcadores) . ')');
    foreach ($ids as $i => $id) {
        $stmt->bindValue(':id' . $i, $id, PDO::PARAM_INT);
    }
    $stmt->execute();
    $itens = [];
    foreach ($stmt->fetchAll() as $p) {
        if (!(int)$p['ativo']) {
            remover((int)$p['id']);
            continue;
        }
        $p['quantidade'] = (int)$_SESSION['carrinho'][$p['id']];
        $p['subtotal'] = $p['quantidade'] * (float)$p['preco'];
        $itens[] = $p;
    }
    return $itens;
}

function calcular_total(array $itens): float
{
    $total = 0.0;
    foreach ($itens as $i) {
        $total += $i['subtotal'];
    }
    return $total;
}

function contar_itens_carrinho(): int
{
    return isset($_SESSION['carrinho']) ? (int)array_sum($_SESSION['carrinho']) : 0;
}
