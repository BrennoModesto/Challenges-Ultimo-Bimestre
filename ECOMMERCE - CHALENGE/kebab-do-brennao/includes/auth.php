<?php
// includes/auth.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/flash.php';

function base_url(): string
{
    $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $dir = dirname($script);
    if (basename($dir) === 'admin') {
        $dir = dirname($dir);
    }
    return rtrim($dir, '/');
}

function redirecionar(string $caminho): void
{
    header('Location: ' . base_url() . '/' . ltrim($caminho, '/'));
    exit;
}

function usuario_logado(): bool
{
    return !empty($_SESSION['usuario_id']);
}

function eh_admin(): bool
{
    return usuario_logado() && ($_SESSION['usuario_perfil'] ?? '') === 'admin';
}

function exigir_login(string $redirect = ''): void
{
    if (!usuario_logado()) {
        flash_set('erro', 'Faça login para continuar.');
        redirecionar('login.php' . ($redirect !== '' ? '?redirect=' . urlencode($redirect) : ''));
    }
}

function exigir_admin(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!eh_admin()) {
        flash_set('erro', 'Acesso restrito a administradores.');
        redirecionar('login.php');
    }
}

function e($valor): string
{
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}

function moeda($valor): string
{
    return 'R$ ' . number_format((float)$valor, 2, ',', '.');
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_campo(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

function csrf_validar(): bool
{
    return isset($_POST['csrf'], $_SESSION['csrf']) && hash_equals($_SESSION['csrf'], (string)$_POST['csrf']);
}

function exigir_csrf(string $voltar): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_validar()) {
        flash_set('erro', 'Requisição inválida. Tente novamente.');
        redirecionar($voltar);
    }
}
