<?php
// config/env.php

function carregar_env(string $caminho): void
{
    if (!is_file($caminho)) {
        http_response_code(500);
        exit('Arquivo .env não encontrado. Copie .env.example para .env.');
    }
    $variaveis = parse_ini_file($caminho, false, INI_SCANNER_RAW);
    if ($variaveis === false) {
        http_response_code(500);
        exit('Arquivo .env inválido.');
    }
    foreach ($variaveis as $chave => $valor) {
        $valor = trim((string)$valor, " \t\"'");
        $_ENV[$chave] = $valor;
        putenv($chave . '=' . $valor);
    }
}

function env(string $chave, ?string $padrao = null): ?string
{
    return $_ENV[$chave] ?? (getenv($chave) !== false ? getenv($chave) : $padrao);
}

carregar_env(__DIR__ . '/../.env');
