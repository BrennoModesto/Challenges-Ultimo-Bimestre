// script.js — Portfólio Lucas Andrade
(() => {
  'use strict';

  /* ============ CONFIGURAÇÃO ============ */
  const STORAGE_KEY = 'portfolio_mensagens';
  const FORMSPREE_ENDPOINT = 'https://formspree.io/f/mwlownrq';
  const AVATAR_FALLBACK = 'data:image/svg+xml,' + encodeURIComponent(
    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400"><defs><linearGradient id="g" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#7c3aed"/><stop offset="1" stop-color="#22d3ee"/></linearGradient></defs><rect width="400" height="400" fill="url(#g)"/><text x="200" y="250" font-family="Arial, sans-serif" font-size="150" font-weight="700" text-anchor="middle" fill="#fff">BM</text></svg>');

  /* ============ ÍCONES (SVG inline) ============ */
  const S = (d) => `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">${d}</svg>`;
  const ICONS = {
    arrow: S('<path d="M5 12h14M13 6l6 6-6 6"/>'),
    code: S('<path d="m8 8-5 4 5 4M16 8l5 4-5 4M14 5l-4 14"/>'),
    spark: S('<path d="M12 3l1.8 5.2L19 10l-5.2 1.8L12 17l-1.8-5.2L5 10l5.2-1.8z"/><path d="M19 17l.7 1.8L21.5 20l-1.8.7L19 22.5l-.7-1.8L16.5 20l1.8-.7z"/>'),
    pin: S('<path d="M12 21s7-6.2 7-11.5A7 7 0 0 0 5 9.5C5 14.8 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/>'),
    mail: S('<rect x="3" y="5" width="18" height="14" rx="2.5"/><path d="m4 7 8 6 8-6"/>'),
    cap: S('<path d="m2 9 10-5 10 5-10 5z"/><path d="M6 11.5V16c0 1.5 2.7 3 6 3s6-1.5 6-3v-4.5"/>'),
    html: S('<path d="m4 3 1.6 17L12 22l6.4-2L20 3z"/><path d="M8 8h8l-.4 5-3.6 1.2L8.4 13"/>'),
    css: S('<path d="m4 3 1.6 17L12 22l6.4-2L20 3z"/><path d="M16 8H8.5l.3 3H15l-.5 4-2.5.8-2.5-.8"/>'),
    js: S('<rect x="3" y="3" width="18" height="18" rx="3"/><path d="M12 11v4.5a1.5 1.5 0 0 1-3 0M15 16c.4.8 1.2 1 2 1 1.100 0 1.800-.5 1.800-1.300 0-2-3.600-1-3.600-3 0-.8.7-1.400 1.800-1.400.8 0 1.400.3 1.800.9"/>'),
    bootstrap: S('<rect x="3" y="3" width="18" height="18" rx="4.5"/><path d="M9 7.5h3.5a2 2 0 0 1 0 4H9zm0 4h4a2.200 2.200 0 0 1 0 4.500H9z"/>'),
    git: S('<circle cx="6" cy="6" r="2.200"/><circle cx="6" cy="18" r="2.200"/><circle cx="18" cy="9" r="2.200"/><path d="M6 8.200v7.600M18 11.200c0 3-6 2-11 5"/>'),
    layout: S('<rect x="3" y="3" width="18" height="18" rx="2.500"/><path d="M3 9h18M9 21V9"/>'),
    phone: S('<rect x="7" y="2.500" width="10" height="19" rx="2.500"/><path d="M11 18.500h2"/>'),
    access: S('<circle cx="12" cy="5" r="1.800"/><path d="M5 8.500c4.600 1.300 9.400 1.300 14 0M12 9v5m0 0-3 6m3-6 3 6"/>'),
    api: S('<path d="M8 7H6a3 3 0 0 0 0 6h2M16 7h2a3 3 0 0 1 0 6h-2M9 10h6M7 17l1.500-3M17 17l-1.500-3"/>'),
    db: S('<ellipse cx="12" cy="6" rx="8" ry="3"/><path d="M4 6v6c0 1.700 3.600 3 8 3s8-1.300 8-3V6M4 12v6c0 1.700 3.600 3 8 3s8-1.300 8-3v-6"/>'),
    figma: S('<path d="M9 3h3v6H9a3 3 0 0 1 0-6zM12 3h3a3 3 0 0 1 0 6h-3zM9 9h3v6H9a3 3 0 0 1 0-6zM9 15h3v3a3 3 0 1 1-3-3z"/><circle cx="15" cy="12" r="3"/>'),
    speed: S('<path d="M4 17a8 8 0 1 1 16 0"/><path d="m12 17 4-5"/>'),
    chat: S('<path d="M4 5h16v11H9l-5 4z"/><path d="M8 9h8M8 12h5"/>'),
    team: S('<circle cx="9" cy="8" r="3"/><circle cx="17" cy="9" r="2.500"/><path d="M3 20c0-3.300 2.700-6 6-6s6 2.700 6 6M15.500 14.200c2.800-.5 5.500 1.300 5.500 4.300"/>'),
    puzzle: S('<path d="M10 4a2 2 0 1 1 4 0v2h4v4h-2a2 2 0 1 0 0 4h2v6h-6v-2a2 2 0 1 0-4 0v2H4v-6h2a2 2 0 1 0 0-4H4V6h6z"/>'),
    clock: S('<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>'),
    learn: S('<path d="M4 5c3-1 6-1 8 1 2-2 5-2 8-1v13c-3-1-6-1-8 1-2-2-5-2-8-1z"/><path d="M12 6v13"/>'),
    heart: S('<path d="M12 20s-8-4.800-8-11a4.500 4.500 0 0 1 8-2.500A4.500 4.500 0 0 1 20 9c0 6.200-8 11-8 11z"/>'),
    adapt: S('<path d="M4 12a8 8 0 0 1 14-5.300L20 9M20 12a8 8 0 0 1-14 5.300L4 15M20 4v5h-5M4 20v-5h5"/>'),
    eye: S('<path d="M2 12s3.600-7 10-7 10 7 10 7-3.600 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/>'),
    shield: S('<path d="M12 3 4 6v6c0 4.500 3.400 8 8 9 4.600-1 8-4.500 8-9V6z"/><path d="m9 12 2 2 4-4"/>'),
    chain: S('<path d="M10 14a4 4 0 0 0 5.700 0l3-3a4 4 0 0 0-5.700-5.700l-1 1M14 10a4 4 0 0 0-5.700 0l-3 3a4 4 0 0 0 5.700 5.700l1-1"/>'),
    robot: S('<rect x="4" y="8" width="16" height="12" rx="3"/><path d="M12 8V4M9 13v1M15 13v1M9 17h6"/><circle cx="12" cy="3.500" r="1"/>'),
    edge: S('<circle cx="12" cy="12" r="3"/><path d="M12 3v3M12 18v3M3 12h3M18 12h3M5.600 5.600l2.100 2.100M16.300 16.300l2.100 2.100M18.400 5.600l-2.100 2.100M7.700 16.300l-2.100 2.100"/>'),
    send: S('<path d="M21 3 10 14M21 3l-7 18-4-7-7-4z"/>'),
    github: S('<path d="M9 19c-4 1.200-4-2-6-2.500M15 21v-3.500c0-1 .1-1.400-.5-2 2.800-.3 5.500-1.400 5.500-6a4.600 4.600 0 0 0-1.300-3.200 4.200 4.200 0 0 0-.1-3.200s-1-.3-3.400 1.300a11.700 11.700 0 0 0-6.200 0C6.600 2.800 5.600 3.100 5.600 3.100a4.200 4.200 0 0 0-.1 3.200A4.600 4.600 0 0 0 4.200 9.500c0 4.600 2.700 5.700 5.500 6-.6.600-.6 1.200-.5 2V21"/>'),
    linkedin: S('<rect x="3" y="3" width="18" height="18" rx="3"/><path d="M8 10v7M8 7v.01M12 17v-4a2.500 2.500 0 0 1 5 0v4M12 10v7"/>'),
    instagram: S('<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><path d="M17.500 6.500v.01"/>'),
    close: S('<path d="M6 6l12 12M18 6 6 18"/>'),
    plus: S('<path d="M12 5v14M5 12h14"/>'),
    refresh: S('<path d="M20 12a8 8 0 1 1-2.500-5.800M20 4v5h-5"/>'),
    edit: S('<path d="M4 20h4L19 9a2.800 2.800 0 0 0-4-4L4 16z"/>'),
    trash: S('<path d="M4 7h16M10 11v6M14 11v6M6 7l1 13h10l1-13M9 7V4h6v3"/>'),
    cpu: S('<rect x="6" y="6" width="12" height="12" rx="2"/><rect x="9.500" y="9.500" width="5" height="5"/><path d="M9 3v3M15 3v3M9 18v3M15 18v3M3 9h3M3 15h3M18 9h3M18 15h3"/>'),
    network: S('<rect x="9" y="3" width="6" height="5" rx="1"/><rect x="2.500" y="16" width="6" height="5" rx="1"/><rect x="15.500" y="16" width="6" height="5" rx="1"/><path d="M12 8v4M5.500 16v-4h13v4"/>'),
    server: S('<rect x="3" y="4" width="18" height="7" rx="2"/><rect x="3" y="13" width="18" height="7" rx="2"/><path d="M7 7.500h.01M7 16.500h.01"/>'),
    home: S('<path d="M3 11 12 4l9 7M5 10v10h14V10M10 20v-6h4v6"/>'),
    bolt: S('<path d="M13 3 5 13h6l-1 8 8-10h-6z"/>'),
    ext: S('<path d="M14 4h6v6M20 4 10 14M18 14v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h5"/>')
  };
  const icon = (n) => ICONS[n] || '';
  const hydrateIcons = (root = document) =>
    root.querySelectorAll('[data-icon]').forEach((el) => { if (!el.firstChild) el.innerHTML = icon(el.dataset.icon); });

  /* ============ UTILITÁRIOS ============ */
  const $ = (s, r = document) => r.querySelector(s);
  const $$ = (s, r = document) => [...r.querySelectorAll(s)];
  const esc = (v) => String(v ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
  const uid = () => Date.now().toString(36) + Math.random().toString(36).slice(2, 8);
  const fmtDate = (iso) => {
    const d = new Date(iso);
    return isNaN(d) ? '—' : d.toLocaleString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' });
  };
  const emailOk = (v) => /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(v);

  function toast(msg, type = 'ok', ms = 4500) {
    const stack = $('#toastStack');
    const el = document.createElement('div');
    el.className = `toast-item ${type}`;
    el.setAttribute('role', type === 'err' ? 'alert' : 'status');
    el.textContent = msg;
    stack.appendChild(el);
    setTimeout(() => { el.classList.add('out'); setTimeout(() => el.remove(), 350); }, ms);
  }

  /* ============ STORAGE (CRUD) ============ */
  const Store = {
    read() {
      try {
        const raw = localStorage.getItem(STORAGE_KEY);
        if (raw === null) return null;
        const data = JSON.parse(raw);
        return Array.isArray(data) ? data : null;
      } catch { return null; }
    },
    write(list) {
      try { localStorage.setItem(STORAGE_KEY, JSON.stringify(list)); return true; }
      catch { toast('Não foi possível gravar no LocalStorage.', 'err'); return false; }
    },
    all() { return this.read() || []; },
    create(data) {
      const list = this.all();
      const rec = { id: uid(), data: new Date().toISOString(), enviado: false, ...data };
      list.unshift(rec);
      this.write(list);
      return rec;
    },
    update(id, patch) {
      const list = this.all();
      const i = list.findIndex((m) => m.id === id);
      if (i < 0) return false;
      list[i] = { ...list[i], ...patch };
      return this.write(list);
    },
    remove(id) { return this.write(this.all().filter((m) => m.id !== id)); }
  };

  /* ============ SEED (20 registros) ============ */
  const SEED_DATA = [
    ['Mariana Costa', 'mariana.costa@techflow.com.br', 'Proposta de freelance', 'Olá Brenno! Vi seu portfólio e gostaria de conversar sobre o redesign do dashboard financeiro da nossa startup. Podemos marcar uma call esta semana?'],
    ['Rafael Oliveira', 'rafael.oliveira@canes.com.br', 'Processo seletivo — Jovem Aprendiz TI', 'Seu perfil chamou a atenção do nosso time de tecnologia. Gostaríamos de agendar uma entrevista, em português e com uma parte em inglês, para a vaga de TI.'],
    ['Beatriz Nogueira', 'bia.nogueira@designhub.co', 'Parceria em projeto de UI', 'Sou designer e estou buscando um dev frontend para transformar um protótipo do Figma em site responsivo. Tem disponibilidade para um projeto de 4 semanas?'],
    ['Thiago Martins', 'thiago.martins@gmail.com', 'Dúvida sobre o Jogo da Memória', 'Gostei muito do Jogo da Memória. Você usou alguma biblioteca para a animação de virar as cartas ou foi tudo em CSS e JavaScript puro? Estou estudando o assunto.'],
    ['Camila Ferreira', 'camila.ferreira@lojaviva.com', 'Orçamento de loja virtual', 'Preciso de uma vitrine online para minha loja de roupas, com carrinho e responsividade. Você poderia me passar um orçamento e prazo estimado?'],
    ['Eduardo Lima', 'eduardo.lima@infosul.net', 'Elogio ao portfólio', 'Parabéns pelo trabalho! As animações de scroll e o painel de projetos estão excelentes. Vou indicar seu portfólio para a turma do curso.'],
    ['Juliana Rocha', 'juliana.rocha@escolaconecta.edu.br', 'Convite para palestra', 'Estamos organizando uma semana de tecnologia na escola e gostaríamos de convidá-lo para falar sobre carreira em desenvolvimento web para os alunos.'],
    ['Gustavo Pereira', 'gustavo.pereira@devmail.com', 'Dúvida sobre JavaScript', 'Estou começando na programação e queria trocar ideias sobre estudos. Tenho dificuldade com assincronismo e consumo de APIs. Pode me indicar materiais?'],
    ['Larissa Mendes', 'larissa.mendes@clinicavida.com.br', 'Site institucional para clínica', 'Nossa clínica precisa de um site moderno com agendamento online e foco em acessibilidade. Podemos conversar sobre o escopo?'],
    ['Felipe Araújo', 'felipe.araujo@cloudbyte.io', 'Contribuição open source', 'Encontrei seu repositório da Calculadora em JavaScript e queria contribuir com o suporte a atalhos de teclado e histórico persistente. Posso abrir um pull request?'],
    ['Patrícia Gomes', 'patricia.gomes@agenciapixel.com', 'Vaga de estágio', 'Temos uma vaga de estágio em desenvolvimento em São Paulo, modelo híbrido, para estudantes de curso técnico. Gostaria de receber seu currículo atualizado.'],
    ['André Barbosa', 'andre.barbosa@fintechx.com', 'Revisão de acessibilidade', 'Precisamos de uma auditoria WCAG no nosso app web antes do lançamento. Você teria interesse em fazer essa consultoria pontual?'],
    ['Renata Duarte', 'renata.duarte@ongfuturo.org', 'Projeto voluntário', 'Somos uma ONG que atende jovens da periferia e precisamos de um site de captação de doações. Haveria possibilidade de trabalho voluntário?'],
    ['Marcos Teixeira', 'marcos.teixeira@uninova.edu.br', 'Trabalho acadêmico', 'Estou pesquisando portfólios de estudantes de TI para meu TCC. Posso citar o seu e fazer algumas perguntas sobre sua trajetória?'],
    ['Carolina Ribeiro', 'carol.ribeiro@moveapp.com.br', 'Desenvolvimento de landing page', 'Vamos lançar um aplicativo de mobilidade e precisamos de uma landing page de alta conversão. O prazo é de duas semanas. Consegue atender?'],
    ['Diego Cardoso', 'diego.cardoso@hotmail.com', 'Problema no formulário', 'Tentei enviar uma mensagem pelo formulário do site e a validação de e-mail não aceitou meu endereço com subdomínio. Poderia verificar?'],
    ['Fernanda Alves', 'fernanda.alves@editoranova.com', 'Blog com painel administrativo', 'Queremos um blog leve com painel para publicar artigos. Gostei do painel oculto do seu site e gostaria de algo parecido. Vamos conversar?'],
    ['Vinícius Santos', 'vinicius.santos@gamedev.studio', 'Interface para jogo web', 'Nosso estúdio está criando um jogo no navegador e precisa de HUD e menus com bom desempenho. Você já trabalhou com Canvas?'],
    ['Aline Carvalho', 'aline.carvalho@rhmais.com.br', 'Feedback sobre seu currículo', 'Sou recrutadora e analisei seu portfólio. Sugiro destacar métricas de desempenho nos projetos. No geral, o material está muito bom!'],
    ['Henrique Souza', 'henrique.souza@logisticapro.com', 'Painel de rastreamento de entregas', 'Precisamos de um painel web para acompanhar entregas em tempo real, com mapas e filtros. Gostaria de uma proposta técnica e de prazos.']
  ];

  function buildSeed() {
    const now = Date.now();
    return SEED_DATA.map(([nome, email, assunto, mensagem], i) => ({
      id: 'seed-' + uid() + i,
      nome, email, assunto, mensagem,
      data: new Date(now - (i + 1) * 1000 * 60 * 60 * (7 + (i % 5) * 9)).toISOString(),
      enviado: i % 4 !== 0
    }));
  }

  // Só injeta quando a chave não existe: nunca duplica registros existentes.
  function ensureSeed() {
    if (Store.read() === null) Store.write(buildSeed());
  }

  /* ============ PROJETOS ============ */
  const REPO = 'https://github.com/BrennoModesto/AULA-31-08';
  const PROJECTS = [
    { t: 'Site de Artes', d: 'Página web desenvolvida para apresentar conteúdos de Artes, com layout responsivo e design criativo.', s: ['HTML5', 'CSS3'], c: ['#8b5cf6', '#22d3ee'], v: 0, u: 'https://github.com/BrennoModesto/AULA-31-08/blob/main/artes.html' },
    { t: 'Site de Biologia', d: 'Página web educacional sobre conteúdos de Biologia, com estrutura semântica e estilo próprio.', s: ['HTML5', 'CSS3'], c: ['#f472b6', '#8b5cf6'], v: 1, u: 'https://github.com/BrennoModesto/AULA-31-08/blob/main/biologia.html' },
    { t: 'Site de História', d: 'Página web com conteúdo histórico, explorando linha do tempo e informações relevantes.', s: ['HTML5', 'CSS3'], c: ['#22d3ee', '#3b82f6'], v: 2, u: 'https://github.com/BrennoModesto/AULA-31-08/blob/main/historia.html' },
    { t: 'Site de Matemática', d: 'Página web com conteúdos matemáticos, fórmulas e explicações didáticas.', s: ['HTML5', 'CSS3'], c: ['#34d399', '#22d3ee'], v: 3, u: 'https://github.com/BrennoModesto/AULA-31-08/blob/main/matematica.html' },
    { t: 'Estilos Globais do Projeto', d: 'Folha de estilos compartilhada entre todas as páginas do projeto, garantindo consistência visual.', s: ['CSS3'], c: ['#6366f1', '#22d3ee'], v: 4, u: 'https://github.com/BrennoModesto/AULA-31-08/blob/main/style.css' },
    { t: 'Repositório Completo — AULA-31-08', d: 'Repositório com o conjunto de páginas web desenvolvidas durante as aulas, unindo HTML5 e CSS3 em um só lugar.', s: ['HTML5', 'CSS3', 'Git'], c: ['#fbbf24', '#f472b6'], v: 5, u: 'https://github.com/BrennoModesto/AULA-31-08' }
  ];


  function shot(c1, c2, v) {
    const bars = [
      '<rect x="40" y="76" width="320" height="22" rx="6" fill="#fff" opacity=".85"/><rect x="40" y="108" width="320" height="16" rx="5" fill="#fff" opacity=".35"/><rect x="40" y="130" width="320" height="16" rx="5" fill="#fff" opacity=".2"/><rect x="40" y="152" width="320" height="16" rx="5" fill="#fff" opacity=".35"/><rect x="40" y="174" width="320" height="16" rx="5" fill="#fff" opacity=".2"/><rect x="40" y="204" width="80" height="22" rx="11" fill="#fff"/>',
      '<rect x="40" y="96" width="140" height="14" rx="7" fill="#fff" opacity=".85"/><rect x="40" y="122" width="210" height="8" rx="4" fill="#fff" opacity=".4"/><rect x="40" y="140" width="180" height="8" rx="4" fill="#fff" opacity=".4"/><rect x="40" y="172" width="96" height="28" rx="14" fill="#fff"/><rect x="270" y="90" width="90" height="120" rx="12" fill="#fff" opacity=".2"/><circle cx="315" cy="135" r="22" fill="#fff" opacity=".6"/>',
      '<path d="M200 100 120 170M200 100 280 170M120 170 200 210M280 170 200 210" stroke="#fff" stroke-width="3" opacity=".6"/><rect x="170" y="80" width="60" height="36" rx="8" fill="#fff"/><rect x="90" y="150" width="60" height="36" rx="8" fill="#fff" opacity=".85"/><rect x="250" y="150" width="60" height="36" rx="8" fill="#fff" opacity=".85"/><rect x="170" y="196" width="60" height="30" rx="8" fill="#fff" opacity=".7"/>',
      '<rect x="120" y="70" width="160" height="34" rx="8" fill="#fff" opacity=".9"/><g fill="#fff"><rect x="120" y="116" width="36" height="28" rx="7" opacity=".5"/><rect x="164" y="116" width="36" height="28" rx="7" opacity=".5"/><rect x="208" y="116" width="36" height="28" rx="7" opacity=".5"/><rect x="252" y="116" width="28" height="28" rx="7"/><rect x="120" y="152" width="36" height="28" rx="7" opacity=".5"/><rect x="164" y="152" width="36" height="28" rx="7" opacity=".5"/><rect x="208" y="152" width="36" height="28" rx="7" opacity=".5"/><rect x="252" y="152" width="28" height="28" rx="7"/><rect x="120" y="188" width="80" height="28" rx="7" opacity=".5"/><rect x="208" y="188" width="36" height="28" rx="7" opacity=".5"/><rect x="252" y="188" width="28" height="28" rx="7"/></g>',
      '<circle cx="110" cy="130" r="30" fill="#fff" opacity=".9"/><rect x="164" y="104" width="160" height="14" rx="7" fill="#fff" opacity=".85"/><rect x="164" y="128" width="120" height="8" rx="4" fill="#fff" opacity=".45"/><rect x="60" y="180" width="80" height="34" rx="9" fill="#fff" opacity=".3"/><rect x="152" y="180" width="80" height="34" rx="9" fill="#fff" opacity=".3"/><rect x="244" y="180" width="80" height="34" rx="9" fill="#fff" opacity=".3"/>',
      '<g fill="#fff"><rect x="70" y="80" width="56" height="64" rx="9" opacity=".9"/><rect x="138" y="80" width="56" height="64" rx="9" opacity=".3"/><rect x="206" y="80" width="56" height="64" rx="9" opacity=".3"/><rect x="274" y="80" width="56" height="64" rx="9" opacity=".9"/><rect x="70" y="156" width="56" height="64" rx="9" opacity=".3"/><rect x="138" y="156" width="56" height="64" rx="9" opacity=".6"/><rect x="206" y="156" width="56" height="64" rx="9" opacity=".6"/><rect x="274" y="156" width="56" height="64" rx="9" opacity=".3"/></g>'
    ];
    const svg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 250"><defs><linearGradient id="g" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="${c1}"/><stop offset="1" stop-color="${c2}"/></linearGradient></defs><rect width="400" height="250" fill="url(#g)"/><circle cx="360" cy="30" r="90" fill="#fff" opacity=".08"/><rect x="16" y="14" width="368" height="222" rx="14" fill="#0a0a0f" opacity=".22"/><circle cx="34" cy="32" r="5" fill="#fff" opacity=".7"/><circle cx="50" cy="32" r="5" fill="#fff" opacity=".5"/><circle cx="66" cy="32" r="5" fill="#fff" opacity=".3"/><rect x="40" y="52" width="320" height="1.500" fill="#fff" opacity=".25"/>${bars[v]}</svg>`;
    return 'data:image/svg+xml,' + encodeURIComponent(svg);
  }

  function renderProjects() {
    const grid = $('#projectGrid');
    grid.innerHTML = PROJECTS.map((p, i) => {
      const url = p.u || REPO;
      return `<div class="col-md-6 col-xl-4 reveal" style="--d:${(i % 3) * 0.1}s">
        <article class="project tilt">
          <div class="project-media">
            <img src="${shot(p.c[0], p.c[1], p.v)}" width="400" height="250" loading="lazy" alt="Captura de tela do projeto ${esc(p.t)}">
            <div class="project-overlay"><a class="btn btn-glow btn-sm" href="${url}" target="_blank" rel="noopener noreferrer" aria-label="Abrir repositório de ${esc(p.t)} (nova aba)">Ver código <span data-icon="ext"></span></a></div>
          </div>
          <div class="project-body">
            <h3>${esc(p.t)}</h3>
            <p>${esc(p.d)}</p>
            <ul class="stack" aria-label="Tecnologias utilizadas">${p.s.map((s) => `<li>${esc(s)}</li>`).join('')}</ul>
            <a class="repo-link" href="${url}" target="_blank" rel="noopener noreferrer"><span data-icon="github"></span> github.com/BrennoModesto <span data-icon="arrow"></span></a>
          </div>
        </article>
      </div>`;
    }).join('');
    hydrateIcons(grid);
  }

  /* ============ UI: NAV, REVEAL, TILT, CONTADORES ============ */
  function initNavbar() {
    const nav = $('#navbar');
    const onScroll = () => nav.classList.toggle('scrolled', window.scrollY > 24);
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });

    // fecha o menu mobile ao navegar
    const menu = $('#menu');
    $$('a[href^="#"]:not(.dropdown-toggle)', menu).forEach((a) =>
      a.addEventListener('click', () => {
        if (menu.classList.contains('show')) bootstrap.Collapse.getOrCreateInstance(menu).hide();
      }));

    // seção ativa
    const groups = {
      humanas: 'conhecimento', natureza: 'conhecimento', matematica: 'conhecimento', linguagens: 'conhecimento',
      ciberseguranca: 'tendencias', blockchain: 'tendencias', automacao: 'tendencias', edge: 'tendencias'
    };
    const links = $$('[data-section]', nav);
    const toggles = $$('[data-group]', nav);
    const sections = $$('main section[id]');
    const setActive = (id) => {
      links.forEach((l) => {
        const on = l.dataset.section === id;
        l.classList.toggle('active', on && !l.classList.contains('btn'));
        if (on) l.setAttribute('aria-current', 'true'); else l.removeAttribute('aria-current');
      });
      toggles.forEach((t) => t.classList.toggle('active', groups[id] === t.dataset.group));
    };
    const io = new IntersectionObserver((entries) => {
      entries.forEach((e) => { if (e.isIntersecting) setActive(e.target.id); });
    }, { rootMargin: '-45% 0px -50% 0px' });
    sections.forEach((s) => io.observe(s));
  }

  function initReveal() {
    const items = $$('.reveal');
    if (!('IntersectionObserver' in window)) { items.forEach((i) => i.classList.add('visible')); return; }
    const io = new IntersectionObserver((entries) => {
      entries.forEach((e) => {
        if (!e.isIntersecting) return;
        e.target.classList.add('visible');
        io.unobserve(e.target);
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    items.forEach((i) => io.observe(i));
  }

  function initCounters() {
    const els = $$('[data-count]');
    const run = (el) => {
      const target = +el.dataset.count; const t0 = performance.now(); const dur = 1400;
      const tick = (t) => {
        const p = Math.min((t - t0) / dur, 1);
        el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3)));
        if (p < 1) requestAnimationFrame(tick);
      };
      requestAnimationFrame(tick);
    };
    const io = new IntersectionObserver((es) => es.forEach((e) => { if (e.isIntersecting) { run(e.target); io.unobserve(e.target); } }), { threshold: 0.6 });
    els.forEach((el) => io.observe(el));
  }

  function initTilt() {
    if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    $$('.tilt').forEach((el) => {
      const max = 5;
      el.addEventListener('pointermove', (e) => {
        const r = el.getBoundingClientRect();
        const x = (e.clientX - r.left) / r.width - 0.5;
        const y = (e.clientY - r.top) / r.height - 0.5;
        el.style.transform = `perspective(900px) rotateX(${(-y * max).toFixed(2)}deg) rotateY(${(x * max).toFixed(2)}deg) translateY(-4px)`;
      });
      el.addEventListener('pointerleave', () => { el.style.transform = ''; });
    });
  }

  function initAvatar() {
    const img = $('#avatar');
    const fallback = () => { img.src = AVATAR_FALLBACK; };
    img.addEventListener('error', fallback, { once: true });
    if (img.complete && img.naturalWidth === 0) fallback();
  }

  /* ============ FORMULÁRIO DE CONTATO ============ */
  const rules = {
    nome: (v) => v.trim().length >= 3,
    email: (v) => emailOk(v.trim()),
    assunto: (v) => v.trim().length >= 3,
    mensagem: (v) => v.trim().length >= 10
  };

  function validateField(el, ruleSet) {
    const ok = ruleSet[el.dataset.rule || el.name](el.value);
    el.classList.toggle('is-invalid', !ok);
    el.classList.toggle('is-valid', ok);
    el.setAttribute('aria-invalid', String(!ok));
    return ok;
  }

  function initForm() {
    const form = $('#contactForm');
    const status = $('#formStatus');
    const btn = $('#btnEnviar');
    const fields = $$('input, textarea', form);

    fields.forEach((f) => {
      f.addEventListener('blur', () => validateField(f, rules));
      f.addEventListener('input', () => { if (f.classList.contains('is-invalid')) validateField(f, rules); });
    });

    const setStatus = (msg, cls) => { status.textContent = msg; status.className = 'form-status mb-0 ' + (cls || ''); };

    async function notify(payload) {
      const ctrl = new AbortController();
      const timer = setTimeout(() => ctrl.abort(), 10000);
      try {
        const res = await fetch(FORMSPREE_ENDPOINT, {
          method: 'POST',
          headers: { Accept: 'application/json' },
          body: (() => {
            const fd = new FormData();
            fd.append('name', payload.nome);
            fd.append('email', payload.email);
            fd.append('subject', payload.assunto);
            fd.append('message', payload.mensagem);
            fd.append('_subject', `[Portfólio] ${payload.assunto}`);
            return fd;
          })(),
          signal: ctrl.signal
        });
        return res.ok;
      } catch { return false; } finally { clearTimeout(timer); }
    }

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const results = fields.map((f) => validateField(f, rules));
      if (results.includes(false)) {
        setStatus('Revise os campos destacados.', 'err');
        toast('Há campos inválidos no formulário.', 'err');
        fields.find((f) => f.classList.contains('is-invalid'))?.focus();
        return;
      }
      const payload = {
        nome: form.nome.value.trim(), email: form.email.value.trim(),
        assunto: form.assunto.value.trim(), mensagem: form.mensagem.value.trim()
      };
      btn.classList.add('loading'); btn.setAttribute('aria-busy', 'true');
      setStatus('Enviando…');

      const rec = Store.create(payload); // 1) persistência local
      const sent = await notify(payload); // 2) automação (Formspree)
      if (sent) Store.update(rec.id, { enviado: true });

      btn.classList.remove('loading'); btn.removeAttribute('aria-busy');
      if (sent) {
        setStatus('Mensagem enviada com sucesso! Obrigado pelo contato.', 'ok');
        toast('Mensagem enviada e notificação disparada.', 'ok');
      } else {
        setStatus('Mensagem salva localmente, mas o envio por e-mail falhou.', 'warn');
        toast('Salva no navegador. Notificação por e-mail não enviada (verifique o ID do Formspree).', 'warn', 7000);
      }
      form.reset();
      fields.forEach((f) => { f.classList.remove('is-valid', 'is-invalid'); f.removeAttribute('aria-invalid'); });
      if (!$('#adminOverlay').hidden) renderAdmin();
    });
  }

  /* ============ PAINEL ADMIN ============ */
  const adminEl = () => $('#adminOverlay');
  let lastFocus = null;

  function renderAdmin() {
    const list = Store.all();
    const q = $('#adminSearch').value.trim().toLowerCase();
    const filtered = q ? list.filter((m) => [m.nome, m.email, m.assunto].join(' ').toLowerCase().includes(q)) : list;
    $('#adminCount').textContent = list.length;
    const body = $('#adminBody');
    if (!filtered.length) {
      body.innerHTML = `<div class="empty-state">${list.length ? 'Nenhuma mensagem corresponde ao filtro.' : 'Nenhuma mensagem armazenada. Crie uma nova ou restaure o seed.'}</div>`;
      return;
    }
    body.innerHTML = filtered.map((m) => `
      <article class="msg-row" data-id="${esc(m.id)}">
        <div class="msg-top">
          <div><span class="msg-name">${esc(m.nome)}</span><span class="msg-mail">${esc(m.email)}</span></div>
          <span class="msg-date">${esc(fmtDate(m.data))}</span>
        </div>
        <div class="msg-subject">${esc(m.assunto)}</div>
        <p class="msg-text">${esc(m.mensagem)}</p>
        <div class="msg-actions">
          <button type="button" class="btn btn-ghost" data-act="edit" aria-label="Editar mensagem de ${esc(m.nome)}"><span data-icon="edit"></span> Editar</button>
          <button type="button" class="btn btn-danger-soft" data-act="delete" aria-label="Deletar mensagem de ${esc(m.nome)}"><span data-icon="trash"></span> <span class="lbl">Deletar</span></button>
          <span class="status-tag ${m.enviado ? 'sent' : ''}">${m.enviado ? 'e-mail enviado' : 'somente local'}</span>
        </div>
      </article>`).join('');
    hydrateIcons(body);
  }

  function trapFocus(container, e) {
    if (e.key !== 'Tab') return;
    const f = $$('button:not([disabled]), input:not([type="hidden"]), textarea, [href]', container).filter((n) => n.offsetParent !== null);
    if (!f.length) return;
    const first = f[0]; const last = f[f.length - 1];
    if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
    else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
  }

  function openAdmin() {
    lastFocus = document.activeElement;
    renderAdmin();
    adminEl().hidden = false;
    document.body.style.overflow = 'hidden';
    $('#adminPanel').focus();
  }
  function closeAdmin() {
    adminEl().hidden = true;
    document.body.style.overflow = '';
    lastFocus?.focus?.();
  }

  function openEditor(rec) {
    const f = $('#editForm');
    f.dataset.mode = rec ? 'edit' : 'create';
    $('#editTitle').textContent = rec ? 'Editar mensagem' : 'Nova mensagem';
    $('#editId').value = rec?.id || '';
    $('#editNome').value = rec?.nome || '';
    $('#editEmail').value = rec?.email || '';
    $('#editAssunto').value = rec?.assunto || '';
    $('#editMensagem').value = rec?.mensagem || '';
    $$('.form-control', f).forEach((c) => c.classList.remove('is-invalid'));
    $('#editOverlay').hidden = false;
    $('#editNome').focus();
  }
  function closeEditor() { $('#editOverlay').hidden = true; if (!adminEl().hidden) $('#adminPanel').focus(); }

  function initAdmin() {
    // Atalho secreto: Ctrl + Shift + A
    document.addEventListener('keydown', (e) => {
      if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key.toLowerCase() === 'a') {
        e.preventDefault();
        adminEl().hidden ? openAdmin() : closeAdmin();
        return;
      }
      if (e.key === 'Escape') {
        if (!$('#editOverlay').hidden) closeEditor();
        else if (!adminEl().hidden) closeAdmin();
      }
      if (!$('#editOverlay').hidden) trapFocus($('#editForm'), e);
      else if (!adminEl().hidden) trapFocus($('#adminPanel'), e);
    });

    $('#adminClose').addEventListener('click', closeAdmin);
    adminEl().addEventListener('mousedown', (e) => { if (e.target === adminEl()) closeAdmin(); });
    $('#editOverlay').addEventListener('mousedown', (e) => { if (e.target.id === 'editOverlay') closeEditor(); });
    $('#editCancel').addEventListener('click', closeEditor);
    $('#adminSearch').addEventListener('input', renderAdmin);
    $('#adminNew').addEventListener('click', () => openEditor(null));

    $('#adminSeed').addEventListener('click', () => {
      if (!confirm('Restaurar o seed substituirá TODAS as mensagens atuais por 20 registros de teste. Continuar?')) return;
      Store.write(buildSeed());
      renderAdmin();
      toast('Seed restaurado: 20 registros de teste.', 'ok');
    });

    // Delegação: editar / deletar (deletar exige segundo clique)
    $('#adminBody').addEventListener('click', (e) => {
      const btn = e.target.closest('[data-act]');
      if (!btn) return;
      const id = btn.closest('.msg-row').dataset.id;
      if (btn.dataset.act === 'edit') {
        openEditor(Store.all().find((m) => m.id === id));
      } else if (btn.dataset.act === 'delete') {
        if (btn.dataset.armed) {
          Store.remove(id); renderAdmin(); toast('Mensagem removida.', 'ok', 2500);
        } else {
          btn.dataset.armed = '1';
          $('.lbl', btn).textContent = 'Confirmar?';
          setTimeout(() => { if (btn.isConnected) { delete btn.dataset.armed; $('.lbl', btn).textContent = 'Deletar'; } }, 3000);
        }
      }
    });

    // Criar / atualizar
    const editRules = { editNome: rules.nome, editEmail: rules.email, editAssunto: rules.assunto, editMensagem: rules.mensagem };
    $('#editForm').addEventListener('submit', (e) => {
      e.preventDefault();
      const controls = $$('.form-control', e.currentTarget);
      const results = controls.map((c) => {
        const ok = editRules[c.id](c.value);
        c.classList.toggle('is-invalid', !ok);
        return ok;
      });
      if (results.includes(false)) return;
      const data = {
        nome: $('#editNome').value.trim(), email: $('#editEmail').value.trim(),
        assunto: $('#editAssunto').value.trim(), mensagem: $('#editMensagem').value.trim()
      };
      const id = $('#editId').value;
      if (id) { Store.update(id, data); toast('Mensagem atualizada.', 'ok', 2500); }
      else { Store.create(data); toast('Mensagem criada.', 'ok', 2500); }
      closeEditor();
      renderAdmin();
    });
  }

  /* ============ INIT ============ */
  document.addEventListener('DOMContentLoaded', () => {
    $('#ano').textContent = new Date().getFullYear();
    ensureSeed();
    renderProjects();
    hydrateIcons();
    initAvatar();
    initNavbar();
    initReveal();
    initCounters();
    initTilt();
    initForm();
    initAdmin();
  });
})();
