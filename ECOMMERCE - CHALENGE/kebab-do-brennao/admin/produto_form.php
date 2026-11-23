<?php
// admin/produto_form.php
require_once __DIR__ . '/../includes/auth.php';
exigir_admin();
require_once __DIR__ . '/../config/database.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$produto = ['id' => '', 'categoria_id' => '', 'nome' => '', 'descricao' => '', 'preco' => '', 'estoque' => 0, 'imagem' => null];

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM produtos WHERE id = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $encontrado = $stmt->fetch();
    if (!$encontrado) {
        flash_set('erro', 'Produto não encontrado.');
        redirecionar('admin/produtos.php');
    }
    $produto = $encontrado;
}
// repopula após erro de validação
if (!empty($_SESSION['produto_old'])) {
    if ((int)($_SESSION['produto_old']['id'] ?? 0) === (int)($id ?: 0)) {
        $produto = array_merge($produto, $_SESSION['produto_old']);
    }
    unset($_SESSION['produto_old']);
}

$categorias = $pdo->query('SELECT id, nome FROM categorias ORDER BY nome')->fetchAll();
$titulo_pagina = $id ? 'Editar produto' : 'Novo produto';
require_once __DIR__ . '/../includes/header.php';
?>
<h1 class="h3 mb-4"><?= e($titulo_pagina) ?></h1>
<form method="post" action="produto_salvar.php" enctype="multipart/form-data" class="card card-form p-4" style="max-width:760px">
    <?= csrf_campo() ?>
    <input type="hidden" name="id" value="<?= e($produto['id']) ?>">
    <div class="mb-3">
        <label class="form-label" for="nome">Nome</label>
        <input class="form-control" id="nome" name="nome" maxlength="150" value="<?= e($produto['nome']) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label" for="categoria_id">Categoria</label>
        <select class="form-select" id="categoria_id" name="categoria_id" required>
            <option value="">Selecione...</option>
            <?php foreach ($categorias as $c): ?>
                <option value="<?= (int)$c['id'] ?>" <?= (int)$produto['categoria_id'] === (int)$c['id'] ? 'selected' : '' ?>><?= e($c['nome']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label" for="descricao">Descrição</label>
        <textarea class="form-control" id="descricao" name="descricao" rows="4"><?= e($produto['descricao']) ?></textarea>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label" for="preco">Preço (R$)</label>
            <input type="number" step="0.01" min="0.01" class="form-control" id="preco" name="preco" value="<?= e($produto['preco']) ?>" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label" for="estoque">Estoque</label>
            <input type="number" min="0" class="form-control" id="estoque" name="estoque" value="<?= e($produto['estoque']) ?>" required>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label" for="imagem">Imagem (JPG, PNG ou WEBP, máx. 2 MB)</label>
        <input type="file" class="form-control" id="imagem" name="imagem" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
        <?php if (!empty($produto['imagem'])): ?>
            <div class="mt-2">
                <img src="<?= e(base_url()) ?>/uploads/<?= e($produto['imagem']) ?>" alt="Imagem atual" style="max-height:100px" class="rounded">
                <div class="form-text">Imagem atual mantida caso nenhuma nova seja enviada.</div>
            </div>
        <?php endif; ?>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-terracota" type="submit">Salvar</button>
        <a href="produtos.php" class="btn btn-outline-secondary">Cancelar</a>
    </div>
</form>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
