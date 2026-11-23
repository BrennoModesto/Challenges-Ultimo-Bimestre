# Kebab do Brennão

E-commerce de **Comidas Árabes** desenvolvido como atividade final do 4º bimestre.

- **Tema:** Comidas Árabes
- **Autor:** Brenno Eduardo Modesto Silva
- **E-mail:** brennoeduardomodestosilva@gmail.com
- **GitHub:** https://github.com/BrennoModesto
- **Curso:** Técnico em Informática — Senac Nações Unidas

## Stack
- PHP 8+ (Apache/XAMPP)
- MySQL/MariaDB via PDO
- HTML5, CSS3, Bootstrap 5 (CDN) e JavaScript vanilla
- Sessões PHP para carrinho e autenticação
- Configuração via arquivo `.env`

## Estrutura de pastas
```
├── index.php, produto.php, carrinho.php, checkout.php, pedido_confirmado.php
├── login.php, cadastro.php, logout.php
├── admin/        (dashboard, produtos, pedidos)
├── config/       (env.php, database.php)
├── includes/     (header, footer, auth, carrinho_funcs, flash)
├── assets/       (css, js)
├── uploads/      (imagens dos produtos)
├── schema.sql, .env.example, .gitignore, README.md
```

## Pré-requisitos
- XAMPP com Apache, MySQL e PHP 8+

## Como rodar
1. Importe o `schema.sql` no phpMyAdmin (cria o banco `kebab_do_brenao` e os dados de teste).
2. Copie `.env.example` para `.env` e ajuste as credenciais.
3. Inicie Apache e MySQL no XAMPP.
4. Coloque a pasta (renomeada para `kebab-do-brennao`) em `htdocs` e acesse `http://localhost/kebab-do-brennao`.

## Credenciais de teste
- Admin: `admin@kebab.com` / `admin123`
- Cliente: `cliente@teste.com` / `cliente123`

## Funcionalidades
- [x] Vitrine com filtro por categoria e busca por nome
- [x] Página de produto com controle de estoque
- [x] Carrinho em sessão (adicionar, alterar, remover, total)
- [x] Cadastro, login e logout
- [x] Checkout com transação PDO e baixa de estoque
- [x] Confirmação de pedido
- [x] Painel admin: dashboard, CRUD de produtos com upload, listagem de pedidos

## Segurança
- Prepared statements PDO em todas as consultas
- `password_hash()` / `password_verify()` e `session_regenerate_id(true)` no login
- Escape de saída com `htmlspecialchars()` (XSS)
- Credenciais em `.env` (ignorado pelo Git; só `.env.example` é versionado)
- `exigir_admin()` no topo de todas as páginas do admin
- Token CSRF nos formulários POST
- Upload validado por MIME, extensão e tamanho (2 MB), com nome único via `uniqid()`
- Transação com `SELECT ... FOR UPDATE` e `UPDATE ... WHERE estoque >= ?` no checkout

## Autor e créditos
Projeto desenvolvido por **Brenno Eduardo Modesto Silva** (Técnico em Informática — Senac Nações Unidas) para fins acadêmicos.

- GitHub: https://github.com/BrennoModesto
- E-mail: brennoeduardomodestosilva@gmail.com
- Fontes: Google Fonts (Inter e Playfair Display) · Framework: Bootstrap 5
