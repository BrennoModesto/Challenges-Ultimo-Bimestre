<?php
// login.php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/database.php';

$redirect = (string)($_GET['redirect'] ?? $_POST['redirect'] ?? '');
$destinos = ['checkout' => 'checkout.php', 'carrinho' => 'carrinho.php'];

if (usuario_logado()) {
    redirecionar($destinos[$redirect] ?? 'index.php');
}

$erro = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim((string)($_POST['email'] ?? ''));
    $senha = (string)($_POST['senha'] ?? '');

    if (!csrf_validar()) {
        $erro = 'Requisição inválida. Tente novamente.';
    } else {
        $stmt = $pdo->prepare('SELECT id, nome, senha, perfil FROM usuarios WHERE email = :email');
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $u = $stmt->fetch();

        if ($u && password_verify($senha, $u['senha'])) {
            $carrinho = $_SESSION['carrinho'] ?? [];
            session_regenerate_id(true);
            $_SESSION['usuario_id']     = (int)$u['id'];
            $_SESSION['usuario_nome']   = $u['nome'];
            $_SESSION['usuario_perfil'] = $u['perfil'];
            $_SESSION['carrinho']       = $carrinho;
            flash_set('sucesso', 'Bem-vindo, ' . $u['nome'] . '!');
            if ($u['perfil'] === 'admin' && $redirect === '') {
                redirecionar('admin/index.php');
            }
            redirecionar($destinos[$redirect] ?? 'index.php');
        }
        $erro = 'E-mail ou senha inválidos.';
    }
}

$titulo_pagina = 'Login';
require_once __DIR__ . '/includes/header.php';
?>
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card card-form p-4">
            <h1 class="h3 mb-3">Entrar</h1>
            <?php if ($erro): ?><div class="alert alert-danger py-2"><?= e($erro) ?></div><?php endif; ?>
            <form method="post" action="login.php">
                <?= csrf_campo() ?>
                <input type="hidden" name="redirect" value="<?= e($redirect) ?>">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= e($email) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" required>
                </div>
                <button type="submit" class="btn btn-terracota w-100">Entrar</button>
            </form>
            <p class="mt-3 mb-0 text-center">Novo por aqui? <a href="cadastro.php">Criar conta</a></p>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
