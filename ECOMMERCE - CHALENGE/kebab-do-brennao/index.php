<?php
// index.php
$titulo_pagina = 'Cardápio';
require_once __DIR__ . '/includes/header.php';

$slug  = trim((string)($_GET['categoria'] ?? ''));
$busca = trim((string)($_GET['busca'] ?? ''));

$sql = 'SELECT p.id, p.nome, p.preco, p.estoque, p.imagem, c.nome AS categoria
        FROM produtos p
        INNER JOIN categorias c ON c.id = p.categoria_id
        WHERE p.ativo = 1';
if ($slug !== '') {
    $sql .= ' AND c.slug = :slug';
}
if ($busca !== '') {
    $sql .= ' AND p.nome LIKE :busca';
}
$sql .= ' ORDER BY p.nome';

$stmt = $pdo->prepare($sql);
if ($slug !== '') {
    $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
}
if ($busca !== '') {
    $stmt->bindValue(':busca', '%' . $busca . '%', PDO::PARAM_STR);
}
$stmt->execute();
$produtos = $stmt->fetchAll();
?>
<section class="hero text-center mb-4">
    <h1>Sabores do Oriente, direto na sua mesa</h1>
    <p class="lead mb-0">Kebabs, esfihas e pratos árabes feitos na hora.</p>
</section>

<form class="row g-2 mb-4" method="get" action="index.php">
    <div class="col-md-4">
        <label for="categoria" class="form-label">Categoria</label>
        <select class="form-select" id="categoria" name="categoria">
            <option value="">Todas</option>
            <?php foreach ($categorias_nav as $c): ?>
                <option value="<?= e($c['slug']) ?>" <?= $slug === $c['slug'] ? 'selected' : '' ?>><?= e($c['nome']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-5">
        <label for="busca" class="form-label">Buscar por nome</label>
        <input type="search" class="form-control" id="busca" name="busca" value="<?= e($busca) ?>" placeholder="Ex.: kebab, esfiha, falafel">
    </div>
    <div class="col-md-3 d-flex align-items-end gap-2">
        <button class="btn btn-terracota flex-fill" type="submit">Filtrar</button>
        <a class="btn btn-outline-secondary" href="index.php">Limpar</a>
    </div>
</form>

<?php if (!$produtos): ?>
    <div class="alert alert-warning">Nenhum produto encontrado para o filtro informado.</div>
<?php else: ?>
<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4">
    <?php foreach ($produtos as $p): $esgotado = (int)$p['estoque'] < 1; ?>
        <div class="col">
            <div class="card card-produto h-100">
                <a href="produto.php?id=<?= (int)$p['id'] ?>" class="card-img-wrap">
                    <?php if ($p['imagem']): ?>
                        <img src="uploads/<?= e($p['imagem']) ?>" class="card-img-top" alt="<?= e($p['nome']) ?>">
                    <?php else: ?>
                        <div class="img-placeholder">🥙</div>
                    <?php endif; ?>
                    <?php if ($esgotado): ?><span class="badge bg-danger badge-estoque">Esgotado</span><?php endif; ?>
                </a>
                <div class="card-body d-flex flex-column">
                    <span class="badge badge-categoria align-self-start mb-2"><?= e($p['categoria']) ?></span>
                    <h5 class="card-title"><?= e($p['nome']) ?></h5>
                    <p class="preco mb-3"><?= e(moeda($p['preco'])) ?></p>
                    <div class="mt-auto d-grid gap-2">
                        <a href="produto.php?id=<?= (int)$p['id'] ?>" class="btn btn-outline-terracota btn-sm">Ver detalhes</a>
                        <form method="post" action="carrinho.php">
                            <?= csrf_campo() ?>
                            <input type="hidden" name="acao" value="adicionar">
                            <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                            <input type="hidden" name="quantidade" value="1">
                            <button type="submit" class="btn btn-terracota btn-sm w-100" <?= $esgotado ? 'disabled' : '' ?>>
                                <?= $esgotado ? 'Indisponível' : 'Adicionar ao carrinho' ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
