const form = document.forms['login'];

form.addEventListener('submit', function(event) {
    event.preventDefault(); // Previene l'invio tradizionale del form

    try {
        loginUser();
    } catch (error) {
        console.error('Errore durante il login:', error);
        alert('Si è verificato un errore durante il login. Riprova.');
    }
});

function loginUser() {
    const form = document.querySelector('form[name="login"]');
    const formData = new FormData(form);
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('/form/login', { 
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(data => {
                throw new Error(data.error || 'Errore sconosciuto durante il login');
            });
        }
        return response.json(); 
    })
    .then(data => {
        // Assicurati che il campo `redirect` esista nella risposta
        if (data.redirect) {
            // Esegui il redirect all'URL specificato
            window.location.href = data.redirect; 
        } else {
            console.error('Nessun campo redirect trovato nella risposta.');
            alert('Errore: il server non ha fornito un URL di redirect.');
        }
    })
    .catch(error => {
        console.error('Errore durante il login:', error);
        alert(error.message || 'Si è verificato un errore durante il login. Riprova.');
    });
}


