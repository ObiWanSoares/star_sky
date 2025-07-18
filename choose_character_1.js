// Gerador de nomes aleatórios + verificação AJAX + gender visual selection

async function checkNameAvailable(name) {
    try {
        const res = await fetch('check_name.php?name=' + encodeURIComponent(name));
        const data = await res.json();
        return !data.taken;
    } catch (e) {
        return false;
    }
}

document.addEventListener("DOMContentLoaded", function() {
    // Gerador de nome aleatório
    const btn = document.getElementById('random-name-btn');
    const input = document.getElementById('char_name_input');
    if (btn && input) {
        btn.addEventListener('click', async function() {
            let tries = 0;
            let rnd = '';
            let available = false;
            btn.disabled = true;
            input.style.opacity = 0.6;
            do {
                const first = window.randomNamesFirst[Math.floor(Math.random() * window.randomNamesFirst.length)];
                const last = window.randomNamesLast[Math.floor(Math.random() * window.randomNamesLast.length)];
                rnd = first + ' ' + last;
                tries++;
                available = await checkNameAvailable(rnd);
            } while (!available && tries < 20);

            btn.disabled = false;
            input.style.opacity = 1;
            if (available) {
                input.value = rnd;
            } else {
                alert("Não foi possível gerar um nome único, tenta de novo!");
            }
        });
    }

    // Gender card visual selection
    const genderCards = document.querySelectorAll('.gender-card');
    genderCards.forEach(card => {
        const radio = card.querySelector('input[type="radio"]');
        card.addEventListener('click', function(e) {
            genderCards.forEach(c => c.classList.remove('selected'));
            card.classList.add('selected');
            if (radio) radio.checked = true;
        });
        // Se já está checked ao carregar, garantir .selected
        if (radio && radio.checked) {
            card.classList.add('selected');
        }
    });

    // Tooltip para o ponto de interrogação
    document.querySelectorAll('.gender-tip').forEach(tip => {
        tip.addEventListener('mouseenter', function() {
            tip.setAttribute('data-tooltip', tip.title);
        });
        tip.addEventListener('mouseleave', function() {
            tip.removeAttribute('data-tooltip');
        });
    });
});