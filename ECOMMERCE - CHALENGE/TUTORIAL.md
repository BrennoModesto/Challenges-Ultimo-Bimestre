# 🥙 Tutorial: como rodar o **Kebab do Brennão** no seu computador (XAMPP)

Este guia leva você do zero até o site funcionando no navegador, passo a passo, sem precisar saber nada de servidor. Se você nunca usou XAMPP, fique tranquilo: é só seguir a ordem.

> 💡 **Antes de começar, entenda a ideia geral.** Um site feito em PHP não abre dando dois cliques no arquivo, como um HTML comum. Ele precisa de um "servidor" que entenda PHP e de um "banco de dados" para guardar produtos, usuários e pedidos. O **XAMPP** instala os dois no seu computador:
>
> - **Apache** → o servidor que executa o PHP e entrega as páginas ao navegador.
> - **MySQL** → o banco de dados onde ficam os dados da loja.
> - **phpMyAdmin** → uma página para mexer no banco com cliques, sem digitar comandos.

## 📑 Índice

1. [Pré-requisitos](#1-pré-requisitos)
2. [Instalação do XAMPP](#2-instalação-do-xampp)
3. [Colocar o projeto na pasta correta](#3-colocar-o-projeto-na-pasta-correta)
4. [Criar o banco de dados](#4-criar-o-banco-de-dados)
5. [Configurar o arquivo .env](#5-configurar-o-arquivo-env)
6. [Acessar o site](#6-acessar-o-site)
7. [Acessar o painel admin](#7-acessar-o-painel-admin)
8. [Problemas comuns e soluções](#8-problemas-comuns-e-soluções)
9. [Checklist final](#9-checklist-final)
10. [Dicas extras](#10-dicas-extras)

---

## 1. Pré-requisitos

### O que você precisa ter

| Item | Obrigatório? | Para que serve |
|------|:------------:|----------------|
| **XAMPP** (com PHP 8 ou superior) | ✅ Sim | Apache + MySQL + PHP + phpMyAdmin |
| **Navegador** (Chrome, Edge ou Firefox) | ✅ Sim | Para abrir o site |
| **Editor de texto** (VS Code ou Bloco de Notas) | ✅ Sim | Para editar o arquivo `.env` |
| **Git** | ⚪ Opcional | Para baixar o projeto do GitHub e enviar alterações |
| **Internet** | ✅ Sim | O site carrega o Bootstrap e as fontes de um CDN (servidor externo) |

### Como verificar se o XAMPP já está instalado

1. Abra o **Explorador de Arquivos** (atalho: tecla **Windows + E**).
2. Clique em **Este Computador** → **Disco Local (C:)**.
3. Procure uma pasta chamada **xampp**.
   - Se existir, abra-a e procure o arquivo **xampp-control.exe**. Se ele estiver lá, o XAMPP já está instalado ✅.
   - Se não existir, siga para a [Seção 2](#2-instalação-do-xampp).

### Como verificar a versão do PHP (precisa ser 8 ou maior)

1. Abra o **XAMPP Control Panel** (veja a Seção 2).
2. Clique no botão **Shell** (no lado direito).
3. Na janela preta que abrir, digite e aperte **Enter**:

```
php -v
```

4. A primeira linha mostra algo como `PHP 8.2.12`. Se o número começar com **8** ou mais, está ótimo ✅. Se for **7** ou menos, instale uma versão mais nova do XAMPP.

### Como verificar se o Git está instalado (opcional)

Abra o **Prompt de Comando** (tecla **Windows**, digite `cmd`, Enter) e digite:

```
git --version
```

Se aparecer algo como `git version 2.43.0`, o Git está instalado. Se aparecer "não é reconhecido como um comando", ele não está (veja o download no passo 3).

### 🔗 Links oficiais

- **XAMPP:** https://www.apachefriends.org/download.html
- **VS Code:** https://code.visualstudio.com/
- **Git:** https://git-scm.com/downloads

---

## 2. Instalação do XAMPP

> ✅ Se o XAMPP já está instalado no seu computador, pule para o item **2.3**.

### 2.1 Baixar

1. Acesse o site oficial:

```
https://www.apachefriends.org/download.html
```

2. Escolha a versão para o seu sistema (**XAMPP para Windows**) com **PHP 8.x** e clique no botão de download.
3. Aguarde o arquivo terminar de baixar (ele tem cerca de 150 MB). O nome será parecido com `xampp-windows-x64-8.2.12-0-VS16-installer.exe`.

### 2.2 Instalar no Windows

1. Dê **dois cliques** no arquivo baixado.
2. ⚠️ Pode aparecer um aviso do **Controle de Conta de Usuário** ou um alerta sobre antivírus/UAC. Clique em **Sim** / **OK**. Isso é normal.
3. Na tela de boas-vindas, clique em **Next**.
4. Na tela **Select Components** (componentes), deixe marcados pelo menos:
   - ✅ **Apache**
   - ✅ **MySQL**
   - ✅ **PHP**
   - ✅ **phpMyAdmin**

   Os outros (Tomcat, Perl, Mercury, etc.) podem ficar desmarcados. Clique em **Next**.
5. Na tela **Installation folder**, deixe o caminho como:

```
C:\xampp
```

   ⚠️ **Não instale dentro de "Arquivos de Programas"** (Program Files). O Windows bloqueia a edição de arquivos ali e isso causa problemas.
6. Clique em **Next** nas telas seguintes (idioma, Bitnami). Você pode **desmarcar** a opção "Learn more about Bitnami".
7. Clique em **Next** para iniciar e aguarde a barra de progresso terminar (de 2 a 5 minutos).
8. Se aparecer o **Firewall do Windows** perguntando se deseja permitir o Apache, marque **Redes privadas** e clique em **Permitir acesso** ✅.
9. Ao final, deixe marcada a opção **Do you want to start the Control Panel now?** e clique em **Finish**.

### 2.3 Abrir o Painel de Controle do XAMPP

- **Jeito 1:** tecla **Windows**, digite `XAMPP Control Panel` e aperte Enter.
- **Jeito 2:** abra `C:\xampp` e dê dois cliques em **xampp-control.exe**.

💡 Se ele pedir para escolher o idioma, escolha **English** (ou o que preferir). O painel é uma janela com uma lista de módulos: **Apache**, **MySQL**, FileZilla, Mercury e Tomcat. Só vamos usar os dois primeiros.

### 2.4 Iniciar o Apache e o MySQL

1. Na linha **Apache**, clique no botão **Start**.
2. Na linha **MySQL**, clique no botão **Start**.

### 2.5 Como saber se está tudo rodando (bolinha verde)

Quando funciona, você vê:

- O nome **Apache** e o nome **MySQL** ficam com **fundo verde** ✅.
- Aparecem números nas colunas **PID(s)** e **Port(s)** (por exemplo, Apache nas portas `80, 443` e MySQL na porta `3306`).
- O botão **Start** passa a se chamar **Stop**.
- A janela de mensagens, embaixo, mostra algo como `Status change detected: running`.

Teste rápido: abra o navegador e acesse:

```
http://localhost
```

Se aparecer a página de boas-vindas do XAMPP (ou o painel "Dashboard"), o Apache está funcionando 🎉.

⚠️ Se algum módulo ficar **vermelho** ou mostrar erro, vá direto à [Seção 8](#8-problemas-comuns-e-soluções).

> 🍎🐧 **Mac e Linux**
> - **Mac:** o XAMPP tem o app **manager-osx** (em `/Applications/XAMPP`). Na aba **Manage Servers**, selecione **Apache Web Server** e **MySQL Database** e clique em **Start**.
> - **Linux:** abra o terminal e rode `sudo /opt/lampp/lampp start`. Para parar, `sudo /opt/lampp/lampp stop`.

---

## 3. Colocar o projeto na pasta correta

### 3.1 Entenda o que é a pasta htdocs

O Apache só mostra no navegador o que estiver dentro de uma pasta especial chamada **htdocs**. Tudo que você colocar lá aparece em `http://localhost/...`.

| Sistema | Caminho da pasta htdocs |
|---------|-------------------------|
| **Windows** | `C:\xampp\htdocs` |
| **Mac** | `/Applications/XAMPP/xamppfiles/htdocs` |
| **Linux** | `/opt/lampp/htdocs` |

💡 **Atalho no Painel do XAMPP:** clique no botão **Explorer** (lado direito) e, na janela que abrir, entre na pasta **htdocs**.

### 3.2 Nome da pasta do projeto

A pasta do projeto deve se chamar exatamente:

```
kebab-do-brennao
```

⚠️ **O nome da pasta faz parte do endereço do site.** Se você chamar a pasta de outra coisa, o endereço muda junto (por exemplo, `http://localhost/outro-nome`). Use letras minúsculas, sem espaços e sem acentos.

### 3.3 Opção A: baixar com Git (recomendado)

1. Abra o **Prompt de Comando** e entre na pasta htdocs:

```
cd C:\xampp\htdocs
```

2. Clone o repositório (troque `NOME-DO-REPOSITORIO` pelo nome real do repositório no seu GitHub):

```
git clone https://github.com/BrennoModesto/NOME-DO-REPOSITORIO.git kebab-do-brennao
```

   O final `kebab-do-brennao` garante que a pasta terá o nome certo, mesmo que o repositório tenha outro nome.
3. Quando terminar, confira se existe `C:\xampp\htdocs\kebab-do-brennao\index.php`.

### 3.4 Opção B: baixar o ZIP (sem Git)

1. Abra o repositório no GitHub, clique no botão verde **Code** → **Download ZIP**.
2. Abra o ZIP baixado (clique com o botão direito → **Extrair tudo...**).
3. Mova a pasta extraída para dentro de `C:\xampp\htdocs` e, se necessário, **renomeie-a** para `kebab-do-brennao`.

### 3.5 ⚠️ Cuidado com a "pasta dentro de pasta"

É um erro muito comum. Abra `C:\xampp\htdocs\kebab-do-brennao` e confira: **o arquivo `index.php` deve estar logo ali**, junto com as pastas **admin**, **config**, **includes**, **assets** e **uploads**.

Se, em vez disso, você vir apenas **mais uma pasta** (por exemplo `kebab-do-brennao-main`), entre nela e mova o conteúdo para a pasta de fora.

✅ Estrutura correta:

```
C:\xampp\htdocs\kebab-do-brennao\
├── index.php
├── produto.php
├── carrinho.php
├── checkout.php
├── login.php
├── cadastro.php
├── schema.sql
├── .env.example
├── admin\
├── assets\
├── config\
├── includes\
└── uploads\
```

> 💡 A pasta **uploads** precisa existir. Se ela estiver faltando (isso pode acontecer em alguns downloads), crie uma pasta vazia chamada **uploads** dentro do projeto.

---

## 4. Criar o banco de dados

O arquivo **schema.sql** é uma "receita" que cria o banco **kebab_do_brenao**, as 5 tabelas e os dados de teste (produtos, categorias e dois usuários).

> 💡 O nome do banco tem **um N só** (`kebab_do_brenao`), diferente do nome da loja e da pasta. É assim mesmo: ele precisa ser idêntico em três lugares (schema, `.env` e código). Não mude.

### 4.1 Abrir o phpMyAdmin

1. Confirme que o **Apache** e o **MySQL** estão verdes no painel do XAMPP.
2. No navegador, acesse:

```
http://localhost/phpmyadmin
```

   (Ou clique no botão **Admin** na linha do **MySQL**, no painel do XAMPP.)
3. Deve aparecer uma tela com uma lista de bancos à esquerda (`information_schema`, `mysql`, `phpmyadmin`, etc.). Não precisa de senha no XAMPP padrão.

### 4.2 Importar o schema.sql (passo a passo com cliques)

1. Na tela inicial do phpMyAdmin, **não selecione nenhum banco**. Fique na página inicial (o schema cria o banco sozinho).
2. No menu do topo, clique na aba **Importar** (em inglês, **Import**).
3. Na seção **Arquivo a importar**, clique no botão **Escolher arquivo** (**Choose file**).
4. Navegue até `C:\xampp\htdocs\kebab-do-brennao` e selecione o arquivo **schema.sql**. Clique em **Abrir**.
5. Role a página até o fim. Deixe as opções como estão (formato **SQL**, conjunto de caracteres **utf-8**).
6. Clique no botão **Importar** (em versões mais antigas, **Executar** / **Go**), no canto inferior.
7. Aguarde alguns segundos. Se tudo deu certo, aparece uma faixa verde: **"A importação foi finalizada com sucesso"** ✅.

### 4.3 Como verificar se as tabelas foram criadas

1. Na coluna da esquerda, clique em **kebab_do_brenao** (se não aparecer, aperte **F5** para atualizar a página).
2. Você deve ver **5 tabelas**:

| Tabela | O que guarda | Linhas esperadas |
|--------|--------------|:----------------:|
| **usuarios** | Clientes e administrador | 2 |
| **categorias** | Kebab, Esfihas, Pratos Árabes, Bebidas | 4 |
| **produtos** | Os itens do cardápio | 10 |
| **pedidos** | Compras realizadas | 0 |
| **itens_pedido** | Itens de cada compra | 0 |

3. Clique em **produtos** → aba **Visualizar** (**Browse**). Você deve ver Kebab de Carne, Esfiha de Queijo, Falafel e os demais ✅.

### 4.4 O que fazer se der erro

| Mensagem ou sintoma | O que fazer |
|---------------------|-------------|
| Os acentos aparecem estranhos (`Ã£`, `Ã§`) | Na tela de importação, em **Conjunto de caracteres do arquivo**, escolha **utf-8** e importe de novo. |
| `Unknown collation: 'utf8mb4_0900_ai_ci'` ou erro de *collation* | Você está usando um MySQL/MariaDB muito antigo ou incompatível. Instale uma versão atual do XAMPP. |
| `#1005 Can't create table` ou erro de chave estrangeira | Importe novamente **pelo início**, sem banco selecionado. O arquivo já trata a ordem das tabelas. |
| "Tamanho máximo exceder" / arquivo não carrega | O `schema.sql` é pequeno (cerca de 4 KB). Confira se você escolheu o arquivo certo, e não uma pasta ou um ZIP. |
| `#1007 Can't create database; database exists` | O banco já existe. Importe de novo: o arquivo apaga e recria as tabelas. |
| Tela branca ou `#2002 Connection refused` | O **MySQL** não está rodando. Volte ao painel do XAMPP e clique em **Start**. |

⚠️ **Importante:** importar o `schema.sql` de novo **apaga todos os dados** (pedidos, usuários cadastrados por você, etc.) e volta tudo ao estado inicial. Isso é útil para "zerar" o projeto, mas use com consciência.

---

## 5. Configurar o .env

O **.env** é um arquivo de configuração com os dados de conexão ao banco (usuário, senha...). Ele não vem pronto: você cria a partir do modelo **.env.example**.

### 5.1 Copiar .env.example para .env

**Opção A: pelo VS Code (mais fácil)**

1. Abra o VS Code → **File** → **Open Folder...** e escolha `C:\xampp\htdocs\kebab-do-brennao`.
2. No painel da esquerda, clique com o botão direito em **.env.example** → **Copy**.
3. Clique com o botão direito em um espaço vazio do painel → **Paste**. Surge um arquivo `.env copy`.
4. Clique nele com o botão direito → **Rename** e digite exatamente `.env`. Aperte **Enter**.

**Opção B: pelo Prompt de Comando**

```
cd C:\xampp\htdocs\kebab-do-brennao
copy .env.example .env
```

**Opção C: pelo Explorador de Arquivos**

1. Copie e cole o **.env.example** na mesma pasta.
2. Renomeie a cópia para `.env`. ⚠️ Se o Windows reclamar ("Você deve digitar um nome de arquivo"), digite `.env.` (com um ponto no final). O Windows remove o ponto extra sozinho.

⚠️ **Cuidado com a extensão escondida:** o arquivo não pode se chamar `.env.txt`. No Explorador, aba **Exibir** → marque **Extensões de nomes de arquivo** para conferir.

### 5.2 Abrir e preencher

Abra o **.env** no VS Code (ou no **Bloco de Notas**). Para o XAMPP padrão, o conteúdo deve ser exatamente este:

```
DB_HOST=localhost
DB_NAME=kebab_do_brenao
DB_USER=root
DB_PASS=
DB_CHARSET=utf8mb4
```

| Variável | O que significa | Valor |
|----------|-----------------|-------|
| `DB_HOST` | Onde o MySQL está (no seu próprio computador) | `localhost` |
| `DB_NAME` | Nome do banco criado pelo schema | `kebab_do_brenao` |
| `DB_USER` | Usuário do MySQL | `root` |
| `DB_PASS` | Senha do MySQL (no XAMPP padrão é **vazia**) | *(deixe em branco)* |
| `DB_CHARSET` | Tipo de caracteres (acentos) | `utf8mb4` |

⚠️ **Regras de ouro:** não coloque espaços ao redor do `=`, não use aspas e não apague a linha `DB_PASS=` (apenas deixe sem nada depois do sinal).

### 5.3 Salvar

Aperte **Ctrl + S** ✅.

### 5.4 Por que o .env não vai para o Git?

O **.env** guarda dados sensíveis (senha do banco). Se ele fosse enviado ao GitHub, qualquer pessoa poderia ver sua senha. Por isso:

- O arquivo **.gitignore** manda o Git **ignorar** o `.env`.
- Só o **.env.example** (que não tem senha real) vai para o repositório, servindo de modelo para quem baixar o projeto.

---

## 6. Acessar o site

### 6.1 Abrir a vitrine

Com Apache e MySQL verdes, acesse no navegador:

```
http://localhost/kebab-do-brennao
```

**O que deve aparecer:** um site em tons de terracota e dourado, com o título **"Sabores do Oriente, direto na sua mesa"**, uma barra de filtro e os cards dos **10 produtos** (Kebab de Carne, Esfiha de Queijo, Falafel, Shawarma...) 🥙.

> 💡 Os produtos de teste não têm foto, então aparece um ícone 🥙 no lugar. Você pode adicionar fotos pelo painel admin (Seção 7).

### 6.2 Credenciais de teste

| Perfil | E-mail | Senha |
|--------|--------|-------|
| **Cliente** | `cliente@teste.com` | `cliente123` |
| **Administrador** | `admin@kebab.com` | `admin123` |

### 6.3 Roteiro de testes (nessa ordem)

**1️⃣ Filtro e busca**
- Escolha **Esfihas** na lista de categorias e clique em **Filtrar**. Só as esfihas devem aparecer.
- Digite `kebab` em **Buscar por nome** e clique em **Filtrar**. Devem aparecer o Kebab de Carne e o Kebab de Frango.
- Clique em **Limpar** para voltar à lista completa.

**2️⃣ Detalhes do produto**
- Clique em **Ver detalhes** em qualquer card. Veja preço, descrição, categoria e a quantidade em estoque.

**3️⃣ Cadastro**
- No topo, clique em **Cadastrar**. Preencha nome, e-mail, senha (mínimo 6 caracteres) e confirmação.
- Clique em **Cadastrar**. Você será levado ao login com a mensagem de sucesso ✅.
- Teste também o erro: tente cadastrar o mesmo e-mail duas vezes (deve avisar que já existe).

**4️⃣ Login**
- Clique em **Entrar** e use `cliente@teste.com` / `cliente123`.
- Teste o erro: digite uma senha errada. Deve aparecer **"E-mail ou senha inválidos."**

**5️⃣ Carrinho**
- Na vitrine, clique em **Adicionar ao carrinho** em 2 ou 3 produtos.
- No carrinho, mude uma quantidade e clique em **Atualizar quantidades**. O subtotal e o total mudam.
- Tente colocar uma quantidade maior que o estoque: o sistema ajusta e avisa.
- Clique em **Remover** em um item. Observe o número no ícone 🛒 do menu.

**6️⃣ Checkout**
- No carrinho, clique em **Finalizar compra**.
- Veja o resumo, escolha **PIX**, **Boleto** ou **Cartão de crédito** e clique em **Confirmar pedido**.
- Deve aparecer a tela **"Pedido confirmado!"** ✅ com o número do pedido.
- Volte à vitrine e abra o produto comprado: o **estoque diminuiu** e o carrinho ficou vazio.

**7️⃣ Teste de segurança (extra)**
- Saia da conta (**Sair**), adicione algo ao carrinho e clique em **Finalizar compra**. O site deve mandar você para o **login** antes de concluir.

---

## 7. Acessar o painel admin

### 7.1 Entrar

1. Saia da conta de cliente (botão **Sair**).
2. Acesse:

```
http://localhost/kebab-do-brennao/admin
```

   Como você ainda não está logado como administrador, o site manda você para o login. (Se entrar pelo login normal com a conta admin, ele já leva direto ao painel.)
3. Entre com:

```
E-mail: admin@kebab.com
Senha:  admin123
```

4. Você verá o **Painel administrativo** com 4 cartões: **Produtos**, **Pedidos**, **Clientes** e **Receita total**.

> 🔒 Teste a proteção: faça login com a conta de **cliente** e tente abrir `http://localhost/kebab-do-brennao/admin`. O acesso deve ser negado ("Acesso restrito a administradores").

### 7.2 O que testar

**CRUD de produtos** (clique em **Gerenciar produtos**)

- ➕ **Criar:** clique em **Novo produto**, preencha nome, categoria, descrição, preço e estoque, envie uma **imagem** (JPG, PNG ou WEBP de até 2 MB) e clique em **Salvar**. Confira o produto novo na vitrine, com a foto.
- ✏️ **Editar:** clique em **Editar** em um produto, mude o preço ou o estoque e salve.
- 🔄 **Ativar/Desativar:** clique em **Desativar**. O produto some da vitrine. Clique em **Ativar** para ele voltar.
- 🗑️ **Excluir:** exclua o produto novo que você criou. Se o produto já tiver sido vendido, o sistema só o **desativa** (para não perder o histórico dos pedidos). Isso é proposital.

**Pedidos** (clique em **Ver pedidos**)

- Veja a lista de pedidos feitos, com cliente, data, forma de pagamento, itens e total. O pedido de teste do checkout deve estar lá ✅.

**Dashboard**

- Volte ao painel e veja se os números de pedidos e receita mudaram.

---

## 8. Problemas comuns e soluções

### 8.1 ⚠️ O Apache não inicia (porta 80 ocupada)

**Sintoma:** a mensagem diz `Port 80 in use by ...` ou `Apache shutdown unexpectedly`. O Apache fica vermelho ou volta ao estado parado.

**O que significa:** outro programa já está usando a "porta" 80 (um tipo de "entrada" que o Apache precisa). Dois programas não podem usar a mesma porta.

**Descobrir quem está usando:** no painel do XAMPP, clique em **Netstat** (lado direito). Procure a linha com a porta `80` e veja o nome do programa.

**Soluções (do mais simples ao mais trabalhoso):**

1. **Feche programas conhecidos** que usam a porta 80: **Skype** (versões antigas), **VMware**, **Zoom**, **Teams** e outros servidores web. Tente iniciar o Apache de novo.
2. **Pare o IIS** (servidor da Microsoft que vem no Windows):
   1. Aperte **Windows + R**, digite `services.msc` e Enter.
   2. Procure **Serviço de Publicação da World Wide Web** (World Wide Web Publishing Service).
   3. Clique com o botão direito → **Parar**. Em **Propriedades**, mude o **Tipo de inicialização** para **Manual**.
3. **Mude a porta do Apache** (se não conseguir liberar a 80):
   1. No painel, na linha **Apache**, clique em **Config** → **Apache (httpd.conf)**.
   2. Localize `Listen 80` e troque por:

   ```
   Listen 8080
   ```

   3. Localize `ServerName localhost:80` e troque por:

   ```
   ServerName localhost:8080
   ```

   4. Salve. Depois, em **Config** → **Apache (httpd-ssl.conf)**, troque `Listen 443` por `Listen 4433` e `<VirtualHost _default_:443>` por `<VirtualHost _default_:4433>`. (Isso evita conflito na porta 443.)
   5. Salve e inicie o Apache.
   6. ✅ **Agora o endereço do site muda:** use `http://localhost:8080/kebab-do-brennao` (e `http://localhost:8080/phpmyadmin`).

### 8.2 ⚠️ O MySQL não inicia (porta 3306 ocupada)

**Sintoma:** `Port 3306 in use` ou `MySQL shutdown unexpectedly`.

**Causas comuns:**
- Você tem **outro MySQL instalado** no Windows (por exemplo, o MySQL Server oficial, serviço `MySQL80`).
- O XAMPP foi aberto **duas vezes**, ou o MySQL do XAMPP ficou preso de uma execução anterior.

**Soluções:**

1. Aperte **Windows + R**, digite `services.msc` e Enter.
2. Procure um serviço chamado **MySQL**, **MySQL80** ou **MariaDB**. Clique com o botão direito → **Parar**. Em **Propriedades**, mude o **Tipo de inicialização** para **Manual**.
3. Volte ao painel do XAMPP e clique em **Start** no MySQL.
4. Se continuar travado, abra o **Gerenciador de Tarefas** (**Ctrl + Shift + Esc**), procure `mysqld.exe`, finalize-o (**Finalizar tarefa**) e tente de novo.

> ⚠️ Evite trocar a porta do MySQL do XAMPP: este projeto lê apenas o host, o nome, o usuário e a senha no `.env`, e não uma porta diferente de `3306`. Libere a porta 3306 em vez de mudá-la.

### 8.3 ❌ `Access denied for user 'root'@'localhost'`

**Significa:** o usuário ou a senha do banco no `.env` não conferem com o MySQL.

**Como resolver:**

1. Abra o **.env** e confira: `DB_USER=root` e `DB_PASS=` (vazio no XAMPP padrão).
2. Verifique se não há espaços sobrando ou aspas (`DB_PASS=""` ou `DB_PASS= ` podem causar problemas).
3. Se você (ou alguém) definiu uma senha para o `root` no phpMyAdmin, coloque essa mesma senha em `DB_PASS=suasenha`.
4. Salve o `.env` e recarregue o site (**F5**).

### 8.4 ❌ `Unknown database 'kebab_do_brenao'` ou "Erro ao conectar ao banco de dados"

**Significa:** o banco ainda não existe (você não importou o schema) ou o nome está diferente.

**Como resolver:**

1. Abra `http://localhost/phpmyadmin` e veja se **kebab_do_brenao** aparece à esquerda.
2. Se não aparecer, refaça a [Seção 4](#4-criar-o-banco-de-dados).
3. Se aparecer, confira se `DB_NAME=kebab_do_brenao` está escrito **exatamente assim** no `.env` (um N só, com `_` e não `-`).
4. Confira se o **MySQL** está verde no painel.

### 8.5 ❌ `Arquivo .env não encontrado`

O site mostra essa mensagem quando o `.env` não existe. Refaça o passo [5.1](#51-copiar-envexample-para-env) e confira que o arquivo está **na raiz** do projeto (ao lado do `index.php`) e que o nome é `.env`, e não `.env.txt`.

### 8.6 ❌ `Class "PDO" not found` / `could not find driver`

**Significa:** a extensão do PHP que conversa com o MySQL está desligada. (No XAMPP padrão ela já vem ligada, mas pode ter sido alterada.)

**Como resolver:**

1. No painel do XAMPP, na linha **Apache**, clique em **Config** → **PHP (php.ini)**.
2. Aperte **Ctrl + F** e procure `pdo_mysql`.
3. Se a linha estiver assim, com ponto e vírgula na frente:

```
;extension=pdo_mysql
```

   remova o `;` para ficar:

```
extension=pdo_mysql
```

4. Confira também que `extension=fileinfo` (usada no upload de imagens) não tem `;` na frente.
5. Salve o arquivo, volte ao painel, clique em **Stop** e depois **Start** no Apache. ✅

### 8.7 ❌ Página em branco (como ver os erros do PHP)

Uma tela branca quase sempre é um erro do PHP que está escondido. Para mostrá-lo:

1. No painel, na linha **Apache**, clique em **Config** → **PHP (php.ini)**.
2. Procure `display_errors` e deixe:

```
display_errors=On
```

3. Procure `error_reporting` e deixe:

```
error_reporting=E_ALL
```

4. Salve, reinicie o Apache (**Stop** → **Start**) e recarregue a página. Agora a mensagem de erro aparece na tela, informando o arquivo e a linha 🔍.

> 💡 Ao terminar, volte `display_errors` para `Off`. Em um site de verdade, mostrar erros ao público é um risco de segurança.

### 8.8 ❌ Erro 404 ("Not Found" / "Object not found!")

**Causas e soluções:**

- ✅ A pasta não está dentro de `C:\xampp\htdocs`. Mova-a para lá.
- ✅ O nome da pasta é diferente do que você digitou na URL. A URL deve ser igual ao nome da pasta: `http://localhost/kebab-do-brennao`.
- ✅ Há pasta dentro de pasta (veja o item [3.5](#35-️-cuidado-com-a-pasta-dentro-de-pasta)).
- ✅ Você digitou `https://` em vez de `http://`. Use **http**.
- ✅ Você mudou a porta do Apache e esqueceu o `:8080` na URL.

### 8.9 ❌ Imagens não aparecem

- **Produtos de teste:** eles realmente **não têm imagem**, e o site mostra o ícone 🥙. Isso é normal. Envie fotos pelo painel admin.
- **Envio de imagem falha:** confira se a pasta **uploads** existe dentro do projeto. Se não existir, crie-a.
- **Formato:** use apenas **JPG, PNG ou WEBP**, com no máximo **2 MB**.
- **Foto enviada, mas não aparece:** confira se o arquivo aparece dentro da pasta `uploads`. Se não aparecer, o PHP não conseguiu gravar nela.
- 🍎🐧 **Mac/Linux:** libere a escrita na pasta com:

```
sudo chmod -R 775 /opt/lampp/htdocs/kebab-do-brennao/uploads
```

  (No Mac, troque o início do caminho por `/Applications/XAMPP/xamppfiles/htdocs`.)
- 💻 **Windows:** normalmente não precisa de permissões. Se não gravar, clique com o botão direito na pasta **uploads** → **Propriedades** → desmarque **Somente leitura**.

### 8.10 ❌ "Requisição inválida. Tente novamente."

O site protege os formulários com um código de segurança guardado na sessão do navegador. Isso acontece se a página ficou aberta por muito tempo ou se os **cookies** estão bloqueados. Recarregue a página (**F5**), confira se os cookies estão permitidos para `localhost` e tente de novo.

### 8.11 📂 Onde ficam os logs de erro

**Pelo painel do XAMPP:** na linha **Apache**, clique em **Logs** e escolha:

- **Apache (error.log)**: erros do servidor.
- **PHP (php_error_log)**: erros dos seus arquivos PHP.

**Pelo Explorador de Arquivos:**

| Log | Caminho |
|-----|---------|
| Erros do Apache | `C:\xampp\apache\logs\error.log` |
| Erros do PHP | `C:\xampp\php\logs\php_error_log` |
| Erros do MySQL | `C:\xampp\mysql\data\mysql_error.log` |

💡 Abra com o Bloco de Notas e vá até o **final** do arquivo: os erros mais recentes ficam lá embaixo.

---

## 9. Checklist final

Marque cada item. Se todos estiverem ✅, está tudo funcionando:

- [ ] **Apache** e **MySQL** estão com fundo verde no painel do XAMPP
- [ ] A pasta do projeto está em `C:\xampp\htdocs\kebab-do-brennao`, com o `index.php` direto dentro dela
- [ ] O banco **kebab_do_brenao** aparece no phpMyAdmin com **5 tabelas**
- [ ] A tabela **produtos** tem **10 itens**
- [ ] O arquivo **.env** existe (e não é `.env.txt`) com os dados corretos
- [ ] `http://localhost/kebab-do-brennao` mostra a vitrine com os produtos
- [ ] Filtro por categoria e busca funcionam
- [ ] Consegui me **cadastrar** e fazer **login** com o cliente de teste
- [ ] Consegui **adicionar ao carrinho**, alterar a quantidade e remover
- [ ] Consegui **finalizar um pedido** e vi a tela "Pedido confirmado!"
- [ ] O **estoque diminuiu** depois da compra
- [ ] Consegui entrar no **admin** com `admin@kebab.com`
- [ ] Consegui **criar, editar e desativar** um produto no admin
- [ ] O pedido que fiz aparece em **Ver pedidos**
- [ ] O cliente comum **não** consegue abrir a área `/admin`

### E se algo não funcionar?

1. **Leia a mensagem de erro** na tela. Ela costuma dizer exatamente o que houve.
2. Procure o problema na [Seção 8](#8-problemas-comuns-e-soluções).
3. Ative `display_errors` e olhe os **logs** (itens 8.7 e 8.11).
4. Em último caso, **comece de novo no banco**: reimporte o `schema.sql` (Seção 4) e reinicie o Apache e o MySQL.
5. Se ainda assim não resolver, anote o que aparece em **log + tela** e peça ajuda ao professor ou aos colegas, mostrando a mensagem completa.

---

## 10. Dicas extras

### 10.1 Como parar o XAMPP ao final

1. No painel do XAMPP, clique em **Stop** na linha **Apache**.
2. Clique em **Stop** na linha **MySQL**.
3. Os fundos verdes somem ✅. Depois clique em **Quit** para fechar o painel.

⚠️ Evite desligar o computador com o MySQL rodando: isso pode corromper o banco. Sempre pare os módulos antes.

> 🍎🐧 **Linux:** `sudo /opt/lampp/lampp stop`.

### 10.2 Como fazer backup do banco

1. Abra `http://localhost/phpmyadmin` e clique em **kebab_do_brenao** à esquerda.
2. Clique na aba **Exportar** (**Export**).
3. Deixe o método **Rápido** e o formato **SQL**.
4. Clique em **Exportar** (ou **Go**). O arquivo `kebab_do_brenao.sql` será baixado ✅.
5. Guarde-o em um lugar seguro (pendrive, nuvem). Para restaurar, use a aba **Importar**, como na Seção 4.

> 💡 As fotos enviadas pelo admin ficam na pasta **uploads**. Copie-a também se quiser um backup completo.

### 10.3 Como subir alterações para o GitHub

Abra o **Prompt de Comando** na pasta do projeto:

```
cd C:\xampp\htdocs\kebab-do-brennao
```

**Na primeira vez** em um computador, configure seu nome e e-mail:

```
git config --global user.name "Seu Nome"
git config --global user.email "seu-email@exemplo.com"
```

**Para enviar as alterações:**

1. Veja o que mudou:

```
git status
```

   ✅ Confira que o **.env** **não** aparece na lista. Se ele aparecer, **não faça o commit** e verifique o `.gitignore`.

2. Prepare os arquivos:

```
git add .
```

3. Registre a alteração com uma mensagem clara (o histórico de commits conta na avaliação):

```
git commit -m "feat: descrição curta do que você fez"
```

4. Envie para o GitHub:

```
git push origin main
```

   Se o navegador abrir pedindo login no GitHub, entre com a sua conta e autorize. (Se pedir senha no terminal, use um **Personal Access Token** do GitHub, não a senha da conta.)

💡 **Bons exemplos de mensagem de commit:**

```
feat: adiciona filtro de produtos por categoria
fix: corrige cálculo do total do carrinho
docs: atualiza o README
```

---

*Projeto acadêmico — Kebab do Brennão · Brenno Eduardo Modesto Silva · Técnico em Informática, Senac Nações Unidas · https://github.com/BrennoModesto*
