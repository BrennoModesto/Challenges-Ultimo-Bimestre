<?php
// admin/produto_excluir.php
require_once __DIR__ . '/../includes/auth.php';
exigir_admin();
require_once __DIR__ . '/../config/database.php';

exigir_csrf('admin/produtos.php');
$id   = (int)($_POST['id'] ?? 0);
$acao = (string)($_POST['acao'] ?? '');

if (!in_array($acao, ['ativar', 'desativar', 'excluir'], true) || $id < 1) {
    flash_set('erro', 'Ação inválida.');
    redirecionar('admin/produtos.php');
}

if ($acao === 'ativar' || $acao === 'desativar') {
    $stmt = $pdo->prepare('UPDATE produtos SET ativo = :a WHERE id = :id');
    $stmt->bindValue(':a', $acao === 'ativar' ? 1 : 0, PDO::PARAM_INT);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    flash_set('sucesso', $acao === 'ativar' ? 'Produto ativado.' : 'Produto desativado.');
    redirecionar('admin/produtos.php');
}

$stmt = $pdo->prepare('SELECT COUNT(*) FROM itens_pedido WHERE produto_id = :id');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();

if ((int)$stmt->fetchColumn() > 0) {
    $upd = $pdo->prepare('UPDATE produtos SET ativo = 0 WHERE id = :id');
    $upd->bindValue(':id', $id, PDO::PARAM_INT);
    $upd->execute();
    flash_set('aviso', 'Produto possui pedidos vinculados e não pode ser excluído; foi apenas desativado.');
    redirecionar('admin/produtos.php');
}

$img = $pdo->prepare('SELECT imagem FROM produtos WHERE id = :id');
$img->bindValue(':id', $id, PDO::PARAM_INT);
$img->execute();
$imagem = $img->fetchColumn();

$del = $pdo->prepare('DELETE FROM produtos WHERE id = :id');
$del->bindValue(':id', $id, PDO::PARAM_INT);
$del->execute();

if ($imagem) {
    $arquivo = __DIR__ . '/../uploads/' . basename($imagem);
    if (is_file($arquivo)) {
        unlink($arquivo);
    }
}
flash_set('sucesso', 'Produto excluído.');
redirecionar('admin/produtos.php');
