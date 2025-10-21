

const popup = document.getElementById("popup");
if (popup) {
    // Disparition automatique après 3 secondes
    setTimeout(() => {
        popup.style.opacity = '0';
        popup.style.transition = 'opacity 0.5s ease';
        setTimeout(() => popup.remove(), 500);
    }, 3000);

    // Disparition au clic
    popup.addEventListener('click', () => popup.remove());
}
