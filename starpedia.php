<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Starpedia - História do Star Sky</title>
    <link href="https://fonts.googleapis.com/css?family=Orbitron:700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="starpedia.css">
    <script src="starpedia.js" defer></script>
</head>
<body data-user-haki="false"><!-- Troca para "true" se o jogador tiver Haki -->
    <div class="starpedia-bg"></div>
    <div class="starpedia-logo-fixed">
        <img src="img/star_sky_logo.png" alt="Logo do Star Sky">
    </div>
    <div class="starpedia-container">
        <nav class="starpedia-menu">
            <h2>Starpedia</h2>
            <ul>
                <li><a href="#" class="active" onclick="selectMainTab('historia')">História do Star Sky</a></li>
                <li><a href="#" onclick="selectMainTab('racas')">Raças & Fações</a></li>
                <li><a href="#" onclick="selectMainTab('tecnologia')">Tecnologia & Naves</a></li>
                <li><a href="#" onclick="selectMainTab('planetas')">Planetas & Sistemas</a></li>
                <li><a href="#" onclick="selectMainTab('mecanicas')">Mecânicas de Jogo</a></li>
                <li><a href="#" onclick="selectMainTab('habilidades')">Habilidades</a></li>
                <li><a href="#" onclick="selectMainTab('guildas')">Guildas</a></li>
            </ul>
        </nav>
        <main class="starpedia-content">

            <!-- Separador: História -->
            <div id="tab-historia" class="starpedia-tab-content active">
                <div class="starpedia-title">História do Star Sky</div>
                <div class="starpedia-epic-quote">
                    “Quando tudo parecia perdido, olhámos novamente para as estrelas.”
                </div>
                <div class="story-section-title">A Origem do Sistema Star Sky</div>
                <p>
                    Muitas décadas atrás, a galáxia Via Láctea entrou no seu capítulo mais sombrio.
                </p>
                <p>
                    Uma guerra sem precedentes devastou mundos inteiros, movida pela ganância, orgulho e medo. Quando as armas falharam, a guerra tornou-se biológica — espalhando morte silenciosa e imparável. Civilizações colapsaram. Ecossistemas inteiros desapareceram. E, um a um, todos os seres vivos da galáxia foram caindo.
                </p>
                <p>
                    Mas nem todos se renderam. Um grupo de visionários — cientistas, engenheiros, exploradores e pensadores — alertaram durante anos os governos e potências da Terra. Ninguém os ouviu. Quando a realidade caiu sobre todos, já era tarde demais.
                </p>
                <p>
                    Com os recursos que conseguiram salvar, estes últimos humanos construíram uma nave colossal, batizada de <b>Aurora</b>, equipada com tecnologia avançada e uma Inteligência Artificial revolucionária, chamada <b>S.E.R.A.</b> (Sistema de Emergência, Racional e Autônomo).
                </p>
                <p>
                    A <b>Aurora</b> foi desenhada para uma missão: abandonar a Via Láctea e encontrar um novo lar entre as estrelas. Os sobreviventes partiram em silêncio, adormecidos em câmaras criogênicas, confiando o futuro da humanidade à nave — e à esperança.
                </p>
                <p>
                    Décadas depois, a <b>Aurora</b> encontrou um sistema desconhecido, com alguns planetas capazes de sustentar vida. Após uma descida difícil, aterraram num mundo promissor, que chamaram de <b>Star Sky Prime</b>, e nomearam todo o sistema como <b>Star Sky</b> — um novo começo para a espécie humana.
                </p>
                <p>
                    Usando a própria estrutura da <b>Aurora</b> e os sistemas da IA <b>S.E.R.A.</b>, os primeiros sobreviventes montaram as fundações da nova cidade. Peça a peça, reciclaram a nave e integraram fragmentos da inteligência artificial para criar infraestruturas, sistemas de energia e suporte vital.
                </p>
                <p>
                    Com coragem e engenho, ergueram as primeiras muralhas e laboratórios, usando tudo o que restava da civilização antiga. Assim nasceu a primeira cidade de <b>Star Sky Prime</b>, símbolo de resiliência e reinvenção.
                </p>
                <p>
                    Com o tempo, o Sistema Star Sky prosperou, mas também começou a tornar-se pequeno demais para o espírito humano.
                </p>
                <p>
                    Hoje, cabe à nova geração olhar novamente para as estrelas.<br>
                    Explorar. Evoluir. Expandir.
                </p>
                <p>
                    Cada indivíduo tem agora a liberdade de escrever a sua própria história no universo de Star Sky — seja como pioneiro, conquistador, comerciante, cientista, ou algo novo. O destino está nas mãos de quem ousar ir mais longe.
                </p>
            </div>

            <!-- Separador: Habilidades -->
            <div id="tab-habilidades" class="starpedia-tab-content" aria-label="Habilidades">
                <div class="starpedia-title">Habilidades</div>
                <div class="story-section-title">O que são Habilidades?</div>
                <p>
                    No universo de Star Sky, habilidades são competências essenciais dos personagens e jogadores, permitindo ações únicas e estratégias diferenciadas. Cada personagem pode explorar um conjunto de habilidades para personalizar o seu percurso e papel na aventura.
                </p>
                <div class="story-section-title">Escolha uma Habilidade para saber mais:</div>
                <div class="habilidades-grid" role="list">
                    <button class="habilidade-card" tabindex="0" data-habilidade="combate" aria-label="Combate">
                        <span class="habilidade-nome">Combate</span>
                    </button>
                    <button class="habilidade-card" tabindex="0" data-habilidade="construcao" aria-label="Construção">
                        <span class="habilidade-nome">Construção</span>
                    </button>
                    <button class="habilidade-card" tabindex="0" data-habilidade="diplomacia" aria-label="Diplomacia">
                        <span class="habilidade-nome">Diplomacia</span>
                    </button>
                    <button class="habilidade-card" tabindex="0" data-habilidade="inteligencia" aria-label="Inteligência">
                        <span class="habilidade-nome">Inteligência</span>
                    </button>
                    <button class="habilidade-card" tabindex="0" data-habilidade="percepcao" aria-label="Perceção">
                        <span class="habilidade-nome">Percepção</span>
                    </button>
                    <button class="habilidade-card" tabindex="0" data-habilidade="pilot" aria-label="Piloto">
                        <span class="habilidade-nome">Piloto</span>
                    </button>
                    <button class="habilidade-card" tabindex="0" data-habilidade="producao" aria-label="Produção">
                        <span class="habilidade-nome">Produção</span>
                    </button>
                    <!-- Haki será injetado via JS apenas para quem tem haki -->
                </div>
                <!-- Modal de habilidade -->
                <div id="habilidade-modal" class="modal-ssky" role="dialog" aria-modal="true" aria-labelledby="habilidade-modal-titulo" aria-hidden="true">
                    <div class="modal-content-ssky">
                        <button class="modal-close-btn" aria-label="Fechar" tabindex="0" onclick="fecharModal('habilidade-modal')">&times;</button>
                        <h3 id="habilidade-modal-titulo"></h3>
                        <p id="habilidade-modal-desc"></p>
                    </div>
                </div>
            </div>

            <!-- Separador: Guildas -->
            <div id="tab-guildas" class="starpedia-tab-content" aria-label="Guildas">
                <div class="starpedia-title">Guildas</div>
                <div class="story-section-title">O que é uma Guilda?</div>
                <p>
                    Uma Guilda é um grupo organizado, com objetivos e especialização no universo Star Sky. Facilita cooperação, proteção e crescimento dos seus membros.
                </p>
                <div class="story-section-title">Como Criar Guilda</div>
                <div class="guilda-placeholder">
                    (Em breve: guia passo-a-passo para fundar a sua própria guilda, requisitos e custos. Fica atento!)
                </div>
                <div class="story-section-title">Tipos de Guilda</div>
                <div class="guildas-grid" role="list">
                    <button class="guilda-card" tabindex="0" data-guilda="equipamento" aria-label="Produção de Equipamento">
                        <span class="guilda-nome">Produção de Equipamento</span>
                    </button>
                    <button class="guilda-card" tabindex="0" data-guilda="medicina" aria-label="Medicina">
                        <span class="guilda-nome">Medicina</span>
                    </button>
                    <button class="guilda-card" tabindex="0" data-guilda="militar" aria-label="Militar">
                        <span class="guilda-nome">Militar</span>
                    </button>
                    <button class="guilda-card" tabindex="0" data-guilda="mineracao" aria-label="Mineração">
                        <span class="guilda-nome">Mineração</span>
                    </button>
                    <button class="guilda-card" tabindex="0" data-guilda="naves" aria-label="Produção de Naves">
                        <span class="guilda-nome">Produção de Naves</span>
                    </button>
                    <button class="guilda-card" tabindex="0" data-guilda="transporte" aria-label="Transporte">
                        <span class="guilda-nome">Transporte</span>
                    </button>
                </div>
                <!-- Modal de guilda -->
                <div id="guilda-modal" class="modal-ssky" role="dialog" aria-modal="true" aria-labelledby="guilda-modal-titulo" aria-hidden="true">
                    <div class="modal-content-ssky">
                        <button class="modal-close-btn" aria-label="Fechar" tabindex="0" onclick="fecharModal('guilda-modal')">&times;</button>
                        <h3 id="guilda-modal-titulo"></h3>
                        <p id="guilda-modal-desc"></p>
                    </div>
                </div>
            </div>

            <div id="tab-racas" class="starpedia-tab-content"></div>
            <div id="tab-tecnologia" class="starpedia-tab-content"></div>
            <div id="tab-planetas" class="starpedia-tab-content"></div>
            <div id="tab-mecanicas" class="starpedia-tab-content"></div>

        </main>
    </div>
    <a href="javascript:history.back()" class="starpedia-voltar-btn" title="Voltar à página anterior">Voltar</a>
    <script>
        // Mantém a navegação entre separadores acessível
        function selectMainTab(tab) {
            const menuLinks = document.querySelectorAll('.starpedia-menu a');
            menuLinks.forEach(l => l.classList.remove('active'));
            const idx = {
                historia: 0, racas: 1, tecnologia: 2, planetas: 3, mecanicas: 4, habilidades: 5, guildas: 6
            }[tab];
            if(menuLinks[idx]) menuLinks[idx].classList.add('active');
            document.querySelectorAll('.starpedia-tab-content').forEach(div => div.classList.remove('active'));
            const tabDiv = document.getElementById('tab-' + tab);
            if(tabDiv) tabDiv.classList.add('active');
        }
    </script>
</body>
</html>