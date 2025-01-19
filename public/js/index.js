// Gestisce il clic sui pulsanti "Leggi di più" per mostrare/nascondere il contenuto
const readMoreButtons = document.querySelectorAll('.faq li button');
readMoreButtons.forEach(button => {
    button.addEventListener('click', () => {
        const content = button.nextElementSibling;
        // Alterna la visualizzazione del contenuto e la rotazione dell'immagine
        if (content.style.display === 'block') {
            content.style.display = 'none';
            button.querySelector('img').style.transform = 'rotate(0deg)';
        } else {
            content.style.display = 'block';
            button.querySelector('img').style.transform = 'rotate(45deg)';
        }
    });
});

// Gestisce l'invio dell'email e aggiorna il testo del pulsante
function setupEmailValidation(emailInputId, signupButtonId) {
    const emailInput = document.getElementById(emailInputId);
    const signupButton = document.getElementById(signupButtonId);
    const signupLink = signupButton.parentElement;

    emailInput.addEventListener("input", function () {
        if (isValidEmail(emailInput.value)) {
            signupButton.disabled = false;
            signupLink.setAttribute("href", "signup");
        } else {
            signupButton.disabled = true;
            signupLink.removeAttribute("href");
        }
    });
}

function isValidEmail(email) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}

setupEmailValidation("signup-email-1", "signup-btn-1");
setupEmailValidation("signup-email-2", "signup-btn-2");


// Cliccando sul pulsante mostra la pagina ads plan
function redirectToAdsPlan() {
    window.location.href = "https://www.netflix.com/it/ads-plan";
}



document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.querySelector('.carousel');
    const gallery = carousel.querySelector('.gallery');
    const prevButton = carousel.querySelector('.arrow.prev');
    const nextButton = carousel.querySelector('.arrow.next');

    // Larghezza di una card + il gap
    const cardWidth = 180 + 32; // 180px (immagine) + 32px (gap)
    const carouselWidth = carousel.offsetWidth; // Larghezza visibile del carosello
    const totalCards = gallery.children.length; // Numero totale di card
    const visibleCards = Math.floor(carouselWidth / cardWidth); // Quante card sono visibili
    const maxScroll = -(cardWidth * (totalCards - visibleCards)); // Scorrimento massimo verso sinistra
    let position = 0; // Posizione iniziale della gallery

    // Funzione per aggiornare la posizione della gallery
    const updateGalleryPosition = () => {
        gallery.style.transform = `translateX(${position}px)`;
    };

    // Event listener per il pulsante "prev"
    prevButton.addEventListener('click', () => {
        position += cardWidth * visibleCards; // Sposta verso destra
        position = Math.min(position, 0); // Non superare l'inizio
        updateGalleryPosition(); // Applica la nuova posizione
    });

    // Event listener per il pulsante "next"
    nextButton.addEventListener('click', () => {
        position -= cardWidth * visibleCards; // Sposta verso sinistra
        position = Math.max(position, maxScroll); // Non superare la fine
        updateGalleryPosition(); // Applica la nuova posizione
    });

    // Adatta il carosello al ridimensionamento della finestra
    window.addEventListener('resize', () => {
        const newCarouselWidth = carousel.offsetWidth;
        const newVisibleCards = Math.floor(newCarouselWidth / cardWidth);
        position = 0; // Resetta la posizione
        updateGalleryPosition(); // Ripristina la posizione
    });
});

