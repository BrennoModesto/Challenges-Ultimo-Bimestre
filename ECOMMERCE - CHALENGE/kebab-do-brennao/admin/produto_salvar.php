<?php
// admin/produto_salvar.php
require_once __DIR__ . '/../includes/auth.php';
exigir_admin();
require_once __DIR__ . '/../config/database.php';

$id = (int)($_POST['id'] ?? 0);
$voltar = 'admin/produto_form.php' . ($id ? '?id=' . $id : '');
exigir_csrf($voltar);

$nome      = trim((string)($_POST['nome'] ?? ''));
$descricao = trim((string)($_POST['descricao'] ?? ''));
$categoria = (int)($_POST['categoria_id'] ?? 0);
$preco     = filter_var(str_replace(',', '.', (string)($_POST['preco'] ?? '')), FILTER_VALIDATE_FLOAT);
$estoque   = filter_var($_POST['estoque'] ?? '', FILTER_VALIDATE_INT);

$_SESSION['produto_old'] = ['id' => $id, 'nome' => $nome, 'descricao' => $descricao, 'categoria_id' => $categoria, 'preco' => $_POST['preco'] ?? '', 'estoque' => $_POST['estoque'] ?? 0];

$erros = [];
if ($nome === '' || mb_strlen($nome) > 150) {
    $erros[] = 'Nome inválido.';
}
if ($preco === false || $preco <= 0) {
    $erros[] = 'Preço inválido.';
}
if ($estoque === false || $estoque < 0) {
    $erros[] = 'Estoque inválido.';
}
$chk = $pdo->prepare('SELECT COUNT(*) FROM categorias WHERE id = :id');
$chk->bindValue(':id', $categoria, PDO::PARAM_INT);
$chk->execute();
if (!(int)$chk->fetchColumn()) {
    $erros[] = 'Categoria inválida.';
}

$imagem_nova = null;
if (!$erros && isset($_FILES['imagem']) && $_FILES['imagem']['error'] !== UPLOAD_ERR_NO_FILE) {
    $f = $_FILES['imagem'];
    if ($f['error'] !== UPLOAD_ERR_OK) {
        $erros[] = 'Falha no upload da imagem.';
    } elseif ($f['size'] > 2 * 1024 * 1024) {
        $erros[] = 'A imagem deve ter no máximo 2 MB.';
    } else {
        $permitidos = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
        $ext_orig = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
        if (!isset($permitidos[$mime]) || !in_array($ext_orig, ['jpg', 'jpeg', 'png', 'webp'], true)) {
            $erros[] = 'Formato de imagem não permitido (use JPG, PNG ou WEBP).';
        } else {
            $imagem_nova = uniqid('prod_') . '.' . $permitidos[$mime];
            if (!move_uploaded_file($f['tmp_name'], __DIR__ . '/../uploads/' . $imagem_nova)) {
                $erros[] = 'Não foi possível salvar a imagem.';
                $imagem_nova = null;
            }
        }
    }
}

if ($erros) {
    foreach ($erros as $er) {
        flash_set('erro', $er);
    }
    redirecionar($voltar);
}
unset($_SESSION['produto_old']);

if ($id) {
    $stmt = $pdo->prepare('SELECT imagem FROM produtos WHERE id = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $atual = $stmt->fetch();
    if (!$atual) {
        flash_set('erro', 'Produto não encontrado.');
        redirecionar('admin/produtos.php');
    }
    $sql = 'UPDATE produtos SET categoria_id = :c, nome = :n, descricao = :d, preco = :p, estoque = :e'
         . ($imagem_nova ? ', imagem = :i' : '') . ' WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
} else {
    $stmt = $pdo->prepare('INSERT INTO produtos (categoria_id, nome, descricao, preco, estoque, imagem) VALUES (:c, :n, :d, :p, :e, :i)');
    $stmt->bindValue(':i', $imagem_nova, $imagem_nova ? PDO::PARAM_STR : PDO::PARAM_NULL);
}
$stmt->bindValue(':c', $categoria, PDO::PARAM_INT);
$stmt->bindValue(':n', $nome, PDO::PARAM_STR);
$stmt->bindValue(':d', $descricao, PDO::PARAM_STR);
$stmt->bindValue(':p', number_format($preco, 2, '.', ''), PDO::PARAM_STR);
$stmt->bindValue(':e', $estoque, PDO::PARAM_INT);
if ($id && $imagem_nova) {
    $stmt->bindValue(':i', $imagem_nova, PDO::PARAM_STR);
}
$stmt->execute();

if ($id && $imagem_nova && !empty($atual['imagem'])) {
    $antiga = __DIR__ . '/../uploads/' . basename($atual['imagem']);
    if (is_file($antiga)) {
        unlink($antiga);
    }
}

flash_set('sucesso', $id ? 'Produto atualizado.' : 'Produto cadastrado.');
redirecionar('admin/produtos.php');
