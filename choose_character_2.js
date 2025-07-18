// UX: Highlight selected card, enable Next only when a race is chosen
document.addEventListener("DOMContentLoaded", function() {
    const raceCards = document.querySelectorAll('.race-card');
    const radios = document.querySelectorAll('input[type="radio"][name="selected_race"]');
    const nextBtn = document.getElementById('next-btn');

    function updateSelection() {
        raceCards.forEach(card => card.classList.remove('selected'));
        radios.forEach((radio, idx) => {
            if (radio.checked) {
                raceCards[idx].classList.add('selected');
            }
        });
        // Ativa o botão se algum radio estiver checked
        nextBtn.disabled = !Array.from(radios).some(r => r.checked);
    }

    // Só precisa do evento change!
    radios.forEach((radio) => {
        radio.addEventListener('change', updateSelection);
    });

    // Inicializa o estado
    updateSelection();
});