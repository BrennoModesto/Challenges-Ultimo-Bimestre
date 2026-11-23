<?php
// includes/header.php
if (ob_get_level() === 0) {
    ob_start();
}
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/carrinho_funcs.php';

$base = base_url();
$titulo_pagina = $titulo_pagina ?? 'Kebab do Brennão';
$categorias_nav = $pdo->query('SELECT nome, slug FROM categorias ORDER BY nome')->fetchAll();
$qtd_carrinho = contar_itens_carrinho();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titulo_pagina) ?> | Kebab do Brennão</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= e($base) ?>/assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg fixed-top navbar-kebab">
    <div class="container">
        <a class="navbar-brand brand" href="<?= e($base) ?>/index.php">🥙 Kebab do Brennão</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Alternar navegação">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menuPrincipal">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="<?= e($base) ?>/index.php">Início</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categorias</a>
                    <ul class="dropdown-menu">
                        <?php foreach ($categorias_nav as $c): ?>
                            <li><a class="dropdown-item" href="<?= e($base) ?>/index.php?categoria=<?= e(urlencode($c['slug'])) ?>"><?= e($c['nome']) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <?php if (eh_admin()): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= e($base) ?>/admin/index.php">Admin</a></li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav align-items-lg-center gap-lg-2">
                <li class="nav-item">
                    <a class="nav-link" href="<?= e($base) ?>/carrinho.php">🛒 Carrinho
                        <span class="badge rounded-pill badge-carrinho" id="contador-carrinho"><?= $qtd_carrinho ?></span>
                    </a>
                </li>
                <?php if (usuario_logado()): ?>
                    <li class="nav-item"><span class="nav-link">Olá, <?= e($_SESSION['usuario_nome']) ?></span></li>
                    <li class="nav-item"><a class="btn btn-sm btn-outline-gold" href="<?= e($base) ?>/logout.php">Sair</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="btn btn-sm btn-outline-gold" href="<?= e($base) ?>/login.php">Entrar</a></li>
                    <li class="nav-item"><a class="btn btn-sm btn-gold" href="<?= e($base) ?>/cadastro.php">Cadastrar</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<main class="container py-4 main-content">
<?php flash_exibir(); ?>
