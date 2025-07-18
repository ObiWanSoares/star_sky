document.addEventListener('DOMContentLoaded', function() {
    const maxPoints = 7;
    const maxPerSkill = 10;
    const skillRows = document.querySelectorAll('.skill-row');
    const pointsRemainingEl = document.getElementById('points-remaining');
    const finalizeBtn = document.getElementById('finalize-btn');
    const form = document.getElementById('skills-form');
    let skillState = {};
    let skillBase = {};

    // Inicializar estado das skills e os valores base (bónus da raça)
    skillRows.forEach(row => {
        const skill = row.dataset.skill;
        const valueEl = row.querySelector('.skill-value');
        const input = row.querySelector('input[type="hidden"]');
        let value = parseInt(valueEl.textContent, 10) || 0;
        skillState[skill] = value;
        skillBase[skill] = value; // O valor inicial é o bónus da raça!
    });

    skillRows.forEach(row => {
        const skill = row.dataset.skill;
        const minus = row.querySelector('.skill-minus');
        const plus = row.querySelector('.skill-plus');

        minus.addEventListener('click', () => {
            if (skillState[skill] > skillBase[skill]) {
                skillState[skill]--;
                update();
            }
        });
        plus.addEventListener('click', () => {
            if ((getTotal() < maxPoints) && (skillState[skill] < maxPerSkill)) {
                skillState[skill]++;
                update();
            }
        });
    });

    function getTotal() {
        let total = 0;
        Object.keys(skillState).forEach(skill => {
            total += Math.max(0, skillState[skill] - skillBase[skill]);
        });
        return total;
    }
    function update() {
        skillRows.forEach(row => {
            const skill = row.dataset.skill;
            const valueEl = row.querySelector('.skill-value');
            const input = row.querySelector('input[type="hidden"]');
            const minus = row.querySelector('.skill-minus');
            const plus = row.querySelector('.skill-plus');
            valueEl.textContent = skillState[skill];
            input.value = skillState[skill];
            minus.disabled = skillState[skill] <= skillBase[skill];
            plus.disabled = (getTotal() >= maxPoints) || (skillState[skill] >= maxPerSkill);
        });
        const total = getTotal();
        pointsRemainingEl.textContent = maxPoints - total;
        finalizeBtn.disabled = (total !== maxPoints);
    }

    update();

    form.addEventListener('submit', function(e){
        if (getTotal() !== maxPoints) {
            e.preventDefault();
            alert('Tens de distribuir todos os pontos antes de finalizar!');
        }
    });
});