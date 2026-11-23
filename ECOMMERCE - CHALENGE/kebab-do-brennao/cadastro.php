<?php
// cadastro.php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/database.php';

if (usuario_logado()) {
    redirecionar('index.php');
}

$erros = [];
$nome = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validar()) {
        $erros[] = 'Requisição inválida. Tente novamente.';
    }
    $nome      = trim((string)($_POST['nome'] ?? ''));
    $email     = trim((string)($_POST['email'] ?? ''));
    $senha     = (string)($_POST['senha'] ?? '');
    $confirmar = (string)($_POST['confirmar'] ?? '');

    if ($nome === '' || mb_strlen($nome) > 100) {
        $erros[] = 'Informe um nome válido (até 100 caracteres).';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 150) {
        $erros[] = 'Informe um e-mail válido.';
    }
    if (strlen($senha) < 6) {
        $erros[] = 'A senha deve ter no mínimo 6 caracteres.';
    }
    if ($senha !== $confirmar) {
        $erros[] = 'As senhas não conferem.';
    }

    if (!$erros) {
        $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE email = :email');
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->fetch()) {
            $erros[] = 'Este e-mail já está cadastrado.';
        }
    }

    if (!$erros) {
        $stmt = $pdo->prepare('INSERT INTO usuarios (nome, email, senha, perfil) VALUES (:nome, :email, :senha, :perfil)');
        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':senha', password_hash($senha, PASSWORD_DEFAULT), PDO::PARAM_STR);
        $stmt->bindValue(':perfil', 'cliente', PDO::PARAM_STR);
        $stmt->execute();
        flash_set('sucesso', 'Cadastro realizado! Faça login para continuar.');
        redirecionar('login.php');
    }
}

$titulo_pagina = 'Cadastro';
require_once __DIR__ . '/includes/header.php';
?>
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card card-form p-4">
            <h1 class="h3 mb-3">Criar conta</h1>
            <?php foreach ($erros as $erro): ?>
                <div class="alert alert-danger py-2"><?= e($erro) ?></div>
            <?php endforeach; ?>
            <form method="post" action="cadastro.php" novalidate class="needs-validation">
                <?= csrf_campo() ?>
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?= e($nome) ?>" maxlength="100" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= e($email) ?>" maxlength="150" required>
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha (mín. 6 caracteres)</label>
                    <input type="password" class="form-control" id="senha" name="senha" minlength="6" required>
                </div>
                <div class="mb-3">
                    <label for="confirmar" class="form-label">Confirmar senha</label>
                    <input type="password" class="form-control" id="confirmar" name="confirmar" minlength="6" required>
                </div>
                <button type="submit" class="btn btn-terracota w-100">Cadastrar</button>
            </form>
            <p class="mt-3 mb-0 text-center">Já tem conta? <a href="login.php">Entrar</a></p>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
