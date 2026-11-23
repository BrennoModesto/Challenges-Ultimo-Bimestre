# Portfólio Web Dinâmico — Brenno Eduardo Modesto Silva

Portfólio de **Brenno Eduardo Modesto Silva**, estudante de Técnico em Informática no Senac Nações Unidas, criado como **Atividade Final do 4º Bimestre** para o processo seletivo da *Canes Solution*. O site é uma single-page com navegação fluida, formulário de contato com **armazenamento local + automação de e-mail** e um **painel administrativo oculto** com CRUD completo sobre o LocalStorage.

**Autor:** Brenno Eduardo Modesto Silva · brennoeduardomodestosilva@gmail.com · São Paulo, SP

Todo o código foi escrito do zero, sem construtores de site, frameworks JS ou back-end.

## Stack utilizada

- HTML5 semântico
- CSS3 puro (Flexbox, Grid, variáveis CSS, transições e animações)
- JavaScript vanilla (ES6+)
- Bootstrap 5.3 (via CDN) — grid, navbar, dropdowns e utilitários
- LocalStorage (persistência em JSON)
- Formspree (automação de notificação por e-mail)
- Google Fonts: Inter (corpo) e Sora (títulos)

## Estrutura de arquivos

```
portfolio/
├── index.html        # Estrutura e conteúdo de todas as seções
├── css/
│   └── style.css     # Tema escuro, glassmorphism, animações e responsividade
├── js/
│   └── script.js     # Seed, CRUD, formulário, painel admin, animações
└── README.md
```

## Como rodar localmente

Não há build nem dependências para instalar. Basta **abrir o `index.html` no navegador** (duplo clique). É necessário acesso à internet apenas para carregar Bootstrap e Google Fonts pelas CDNs.

## Seções do site

Início · Sobre (perfil, trajetória acadêmica em linha do tempo, hard skills, soft skills) · Áreas do Conhecimento (Humanas, Natureza, Matemática, Linguagens) · Tendências Tecnológicas (Cibersegurança, Blockchain, Automação e Robótica, Edge Computing) · Galeria de Projetos (6 projetos reais publicados no GitHub, listados abaixo) · Contato.

## Projetos

Os 6 projetos da galeria, todos no GitHub de [BrennoModesto](https://github.com/BrennoModesto):

1. **Site de Artes** (HTML5, CSS3) — <https://github.com/BrennoModesto/AULA-31-08/blob/main/artes.html>
2. **Site de Biologia** (HTML5, CSS3) — <https://github.com/BrennoModesto/AULA-31-08/blob/main/biologia.html>
3. **Site de História** (HTML5, CSS3) — <https://github.com/BrennoModesto/AULA-31-08/blob/main/historia.html>
4. **Site de Matemática** (HTML5, CSS3) — <https://github.com/BrennoModesto/AULA-31-08/blob/main/matematica.html>
5. **Estilos Globais do Projeto** (CSS3) — <https://github.com/BrennoModesto/AULA-31-08/blob/main/style.css>
6. **Repositório Completo — AULA-31-08** (HTML5, CSS3, Git) — <https://github.com/BrennoModesto/AULA-31-08>

## Automação de formulário: Formspree

**Escolha:** o Formspree recebe um `POST` com os dados do formulário e envia um e-mail ao dono da conta, sem back-end próprio. Isso se encaixa na restrição de projeto 100% client-side, tem plano gratuito, aceita `fetch` com JSON e responde com CORS liberado. Alternativas como EmailJS ou Zapier exigiriam chaves públicas no código ou configuração mais extensa.

**Fluxo ao enviar o formulário:**
1. Os campos são validados no cliente (nome ≥ 3, e-mail válido, assunto ≥ 3, mensagem ≥ 10 caracteres).
2. A mensagem é salva no LocalStorage (`portfolio_mensagens`).
3. O `fetch` faz `POST` no endpoint do Formspree.
4. Um toast e uma mensagem inline informam sucesso ou falha. Se o envio falhar, a mensagem continua salva localmente e aparece como "somente local" no painel.

**Endpoint configurado:** o formulário já usa o endpoint real do Formspree, `https://formspree.io/f/mwlownrq`, definido na constante `FORMSPREE_ENDPOINT` no topo de `js/script.js`. O envio é um `fetch` com `POST`, header `Accept: application/json` e corpo `FormData`. No primeiro envio o Formspree pode pedir a confirmação do e-mail da conta; depois disso, cada mensagem chega à caixa de entrada de **brennoeduardomodestosilva@gmail.com**.

## Painel administrativo oculto

Não há botão ou link para ele na interface. Para abrir, pressione:

**`Ctrl + Shift + A`** (em macOS, também `⌘ + Shift + A`)

Pressione o atalho de novo, `Esc` ou clique fora do painel para fechar. Se o navegador interceptar o atalho (o Chrome usa `Ctrl + Shift + A` para "Pesquisar guias" em algumas versões), clique antes em qualquer ponto da página para dar foco ao site.

O painel traz: contador total de mensagens, busca por nome/e-mail/assunto, edição, exclusão (com confirmação em dois cliques), criação manual e restauração do seed.

## Seed automático (20 registros)

No primeiro acesso, se a chave `portfolio_mensagens` **não existir** no LocalStorage, o `script.js` injeta 20 mensagens realistas (nomes, e-mails, assuntos e textos variados). A verificação ocorre apenas quando a chave está ausente, então **nunca duplica** registros nos acessos seguintes, nem recria dados que você apagou de propósito. O botão **Restaurar seed** do painel substitui o conteúdo atual pelos 20 registros originais.

Para simular um "primeiro acesso" novamente: DevTools → *Application* → *Local Storage* → apague `portfolio_mensagens` e recarregue a página.

## Como testar o CRUD completo

1. Abra o site e aperte `Ctrl + Shift + A`. O contador deve mostrar **20** (**Read**).
2. **Create (formulário):** preencha e envie o formulário de Contato; reabra o painel e veja o contador em 21, com a nova mensagem no topo.
3. **Create (manual):** no painel, clique em *Nova mensagem*, preencha os campos e salve.
4. **Update:** clique em *Editar* em qualquer mensagem, altere os campos e salve.
5. **Delete:** clique em *Deletar* e, em até 3 segundos, em *Confirmar?*. O contador diminui.
6. **Restaurar:** clique em *Restaurar seed* e confirme; o contador volta a 20.
7. **Persistência:** recarregue a página e reabra o painel. Os dados permanecem. Você também pode inspecionar o JSON em DevTools → *Application* → *Local Storage* → `portfolio_mensagens`.

## Acessibilidade e responsividade

Abordagem Mobile First com grid do Bootstrap e CSS Grid/Flexbox. Inclui link "Pular para o conteúdo", foco visível, `aria-label` nos controles, `aria-live` nos avisos do formulário, foco preso nos modais e respeito a `prefers-reduced-motion`.

## Autor e créditos

- **Autor:** Brenno Eduardo Modesto Silva — Técnico em Informática, Senac Nações Unidas.
- Projeto acadêmico: Atividade Final do 4º Bimestre.
- Os repositórios dos projetos apontam para `https://github.com/BrennoModesto`. O LinkedIn aponta para <https://www.linkedin.com/in/brenno-modesto-6a8419379/>.
- Créditos: [Bootstrap](https://getbootstrap.com), [Google Fonts](https://fonts.google.com) (Inter e Sora), [Formspree](https://formspree.io) e [UI Avatars](https://ui-avatars.com) (avatar com as iniciais BM; há um SVG inline de reserva). Os ícones e as capturas de tela dos projetos são SVGs criados inline.
