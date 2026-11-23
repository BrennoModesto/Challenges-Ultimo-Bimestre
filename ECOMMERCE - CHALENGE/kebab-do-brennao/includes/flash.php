<?php
// includes/flash.php

function flash_set(string $tipo, string $mensagem): void
{
    $_SESSION['flash'][] = ['tipo' => $tipo, 'mensagem' => $mensagem];
}

function flash_exibir(): void
{
    if (empty($_SESSION['flash'])) {
        return;
    }
    foreach ($_SESSION['flash'] as $f) {
        $classe = $f['tipo'] === 'sucesso' ? 'success' : ($f['tipo'] === 'aviso' ? 'warning' : 'danger');
        echo '<div class="alert alert-' . $classe . ' alert-dismissible fade show flash-msg" role="alert">'
            . htmlspecialchars($f['mensagem'], ENT_QUOTES, 'UTF-8')
            . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button></div>';
    }
    unset($_SESSION['flash']);
}
