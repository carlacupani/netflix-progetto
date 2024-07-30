"use strict";

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
var btnInviaEmail = document.getElementById("signup-btn");
btnInviaEmail.addEventListener("click", function() {
    var campoEmail = document.getElementById("signup-email");
    var testoInserito = campoEmail.value;
    console.log("Testo dell'email:", testoInserito);
    btnInviaEmail.classList.add("email-inviata");
    btnInviaEmail.textContent = "Email Inviata!";
});

// Mostra il secondo logo e nasconde il primo al passaggio del mouse
function showLogo2() {
    var logo = document.getElementById("logo1");
    var hiddenImage = document.getElementById("logo2");
    hiddenImage.style.display = "inline-block";
    logo.style.display = "none";
}

// Nasconde il secondo logo e mostra il primo quando il mouse esce
function hideLogo2() {
    var logo = document.getElementById("logo1");
    var hiddenImage = document.getElementById("logo2");
    hiddenImage.style.display = "none";
    logo.style.display = "inline-block";
}

// Aggiunge eventi di passaggio del mouse al primo logo
var logo = document.getElementById("logo1");
logo.addEventListener("mouseover", showLogo2);
logo.addEventListener("mouseout", hideLogo2);
