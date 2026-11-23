<?php
// produto.php
require_once __DIR__ . '/includes/header.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$produto = null;
if ($id) {
    $stmt = $pdo->prepare('SELECT p.*, c.nome AS categoria, c.slug AS categoria_slug
        FROM produtos p INNER JOIN categorias c ON c.id = p.categoria_id
        WHERE p.id = :id AND p.ativo = 1');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $produto = $stmt->fetch();
}
if (!$produto) {
    flash_set('erro', 'Produto não encontrado.');
    redirecionar('index.php');
}
$estoque = (int)$produto['estoque'];
?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Início</a></li>
        <li class="breadcrumb-item"><a href="index.php?categoria=<?= e(urlencode($produto['categoria_slug'])) ?>"><?= e($produto['categoria']) ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= e($produto['nome']) ?></li>
    </ol>
</nav>
<div class="row g-4">
    <div class="col-md-6">
        <?php if ($produto['imagem']): ?>
            <img src="uploads/<?= e($produto['imagem']) ?>" class="img-fluid rounded-4 shadow-sm w-100" alt="<?= e($produto['nome']) ?>">
        <?php else: ?>
            <div class="img-placeholder img-placeholder-lg rounded-4">🥙</div>
        <?php endif; ?>
    </div>
    <div class="col-md-6">
        <span class="badge badge-categoria mb-2"><?= e($produto['categoria']) ?></span>
        <h1 class="h2"><?= e($produto['nome']) ?></h1>
        <p class="preco display-6 my-3"><?= e(moeda($produto['preco'])) ?></p>
        <p><?= nl2br(e($produto['descricao'])) ?></p>
        <p>
            <?php if ($estoque < 1): ?>
                <span class="badge bg-danger">Esgotado</span>
            <?php else: ?>
                <span class="badge bg-success">Em estoque</span>
                <span class="text-muted ms-2"><?= $estoque ?> unidade(s) disponível(is)</span>
            <?php endif; ?>
        </p>
        <form method="post" action="carrinho.php" class="row g-2 align-items-end">
            <?= csrf_campo() ?>
            <input type="hidden" name="acao" value="adicionar">
            <input type="hidden" name="id" value="<?= (int)$produto['id'] ?>">
            <div class="col-4 col-sm-3">
                <label for="quantidade" class="form-label">Quantidade</label>
                <input type="number" class="form-control" id="quantidade" name="quantidade" value="1" min="1" max="<?= $estoque ?>" required <?= $estoque < 1 ? 'disabled' : '' ?>>
            </div>
            <div class="col-8 col-sm-9">
                <button type="submit" class="btn btn-terracota" <?= $estoque < 1 ? 'disabled' : '' ?>>Adicionar ao carrinho</button>
                <a href="index.php" class="btn btn-outline-secondary">Voltar</a>
            </div>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
