// Dados das habilidades (alfabético, Haki só injetado se autorizado)
const habilidadesInfo = {
    combate: {
        nome: "Combate",
        desc: "Especialização em armas, táticas, defesa e ataque, tanto corpo-a-corpo como à distância. Essencial para missões de risco e proteção de aliados."
    },
    construcao: {
        nome: "Construção",
        desc: "Capacidade de erguer infraestruturas, bases, reparar sistemas e criar novos edifícios. Fundamental para a expansão e segurança das colónias."
    },
    diplomacia: {
        nome: "Diplomacia",
        desc: "Habilidade de negociar, formar alianças, resolver conflitos pacificamente e obter vantagens por meio de diálogo estratégico."
    },
    inteligencia: {
        nome: "Inteligência",
        desc: "Domínio em operações de análise, recolha de informação, descodificação de dados e antecipação de movimentos inimigos ou eventos."
    },
    percepcao: {
        nome: "Percepção",
        desc: "Atenção a detalhes, deteção de perigos e oportunidades, reconhecimento de pistas e sobrevivência em ambientes adversos."
    },
    pilot: {
        nome: "Piloto",
        desc: "Permite controlar qualquer nave ou veículo, desbloqueando manobras evasivas, saltos interplanetários e garantindo segurança em viagens perigosas."
    },
    producao: {
        nome: "Produção",
        desc: "Gestão e fabrico de recursos, desde alimentos até peças tecnológicas. Essencial para manter o fluxo de provisões e o crescimento sustentável."
    },
    haki: {
        nome: "Haki",
        desc: "Poder especial e raro, mistura de força de vontade, intuição e capacidade de superar limites físicos ou mentais. Pode influenciar o ambiente e os outros."
    }
};

// Dados das guildas (alfabético)
const guildasInfo = {
    equipamento: {
        nome: "Produção de Equipamento",
        desc: "Fabrico de armas, armaduras e gadgets tecnológicos. Vantagem: equipamentos exclusivos e capacidade de adaptação rápida às necessidades da guilda."
    },
    medicina: {
        nome: "Medicina",
        desc: "Dedica-se à saúde, investigação de curas e tratamento de feridos/doentes. Vantagem: bónus de recuperação, acesso a laboratórios e medicamentos únicos."
    },
    militar: {
        nome: "Militar",
        desc: "Especializada em defesa, combate, operações estratégicas e segurança de territórios. Vantagem: acesso a armamento avançado, missões militares e proteção reforçada."
    },
    mineracao: {
        nome: "Mineração",
        desc: "Focada na extração de recursos, metais preciosos e minerais raros. Vantagem: maior eficiência e acesso a zonas exclusivas de mineração."
    },
    naves: {
        nome: "Produção de Naves",
        desc: "Criação, reparação e customização de naves espaciais. Vantagem: acesso prioritário a modelos novos e upgrades exclusivos."
    },
    transporte: {
        nome: "Transporte",
        desc: "Responsável por logística, rotas comerciais e transferência de bens e pessoas entre planetas. Vantagem: naves especializadas e acesso a rotas seguras."
    }
};

document.addEventListener("DOMContentLoaded", () => {
    // HABILIDADE HAKI SECRETA
    const hasHaki = document.body.getAttribute('data-user-haki') === "true";
    if (hasHaki) {
        // Cria o cartão do Haki e coloca como 8º elemento
        const habilidadesGrid = document.querySelector('.habilidades-grid');
        let hakiBtn = document.createElement('button');
        hakiBtn.className = 'habilidade-card';
        hakiBtn.tabIndex = 0;
        hakiBtn.dataset.habilidade = 'haki';
        hakiBtn.setAttribute('aria-label', 'Haki');
        hakiBtn.innerHTML = '<span class="habilidade-nome">Haki</span>';
        habilidadesGrid.appendChild(hakiBtn);
    }

    // Modal Habilidades
    document.querySelectorAll('.habilidade-card').forEach(card => {
        card.addEventListener('click', function() {
            const key = card.dataset.habilidade;
            const info = habilidadesInfo[key];
            if(info) {
                document.getElementById('habilidade-modal-titulo').textContent = info.nome;
                document.getElementById('habilidade-modal-desc').textContent = info.desc;
                abrirModal('habilidade-modal');
            }
        });
        card.addEventListener('keydown', function(e){
            if(e.key === "Enter" || e.key === " "){ card.click(); }
        });
    });

    // Modal Guildas
    document.querySelectorAll('.guilda-card').forEach(card => {
        card.addEventListener('click', function() {
            const key = card.dataset.guilda;
            const info = guildasInfo[key];
            if(info) {
                document.getElementById('guilda-modal-titulo').textContent = info.nome;
                document.getElementById('guilda-modal-desc').textContent = info.desc;
                abrirModal('guilda-modal');
            }
        });
        card.addEventListener('keydown', function(e){
            if(e.key === "Enter" || e.key === " "){ card.click(); }
        });
    });
});

// Modal helpers
function abrirModal(id) {
    const modal = document.getElementById(id);
    modal.setAttribute('aria-hidden', 'false');
    modal.classList.add('open');
    // Focus accessibility
    modal.querySelector('.modal-close-btn').focus();
    document.body.style.overflow = "hidden";
}
function fecharModal(id) {
    const modal = document.getElementById(id);
    modal.setAttribute('aria-hidden', 'true');
    modal.classList.remove('open');
    document.body.style.overflow = "";
}
// Fecha modal com ESC
document.addEventListener('keydown', function(e){
    if(e.key === "Escape") {
        if(document.getElementById('habilidade-modal').classList.contains('open')) fecharModal('habilidade-modal');
        if(document.getElementById('guilda-modal').classList.contains('open')) fecharModal('guilda-modal');
    }
});