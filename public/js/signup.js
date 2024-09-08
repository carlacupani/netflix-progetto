function checkName(event) {
    const input = event.currentTarget;

    if (formStatus[input.name] = input.value.length > 0) {
        input.parentNode.classList.remove('errorj');
    } else {
        input.parentNode.classList.add('errorj');
    }
}

function checkSurname(event) {
    const input = event.currentTarget;
    
    if (formStatus[input.surname] = input.value.length > 0) {
        input.parentNode.classList.remove('errorj');
    } else {
        input.parentNode.classList.add('errorj');
    }
}

function jsonCheckUsername(json) {
    
    if (formStatus.username = !json.exists) {
        document.querySelector('.username').classList.remove('errorj');
    } else {
        document.querySelector('.username span').textContent = "Nome utente già utilizzato";
        document.querySelector('.username').classList.add('errorj');
    }
}

function jsonCheckEmail(json) {
    
    if (formStatus.email = !json.exists) {
        document.querySelector('.email').classList.remove('errorj');
    } else {
        document.querySelector('.email span').textContent = "Email già utilizzata";
        document.querySelector('.email').classList.add('errorj');
    }
}

function fetchResponse(response) {
    if (!response.ok) return null;
    return response.json();
}

function checkUsername() {
    const input = document.querySelector('.username input');
    const username = input.value;
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    return new Promise((resolve, reject) => {
        if (!/^[a-zA-Z0-9_]{1,15}$/.test(input.value)) {
            input.parentNode.querySelector('span').textContent = "Sono ammesse lettere, numeri e underscore. Max. 15";
            input.parentNode.classList.add('errorj');
            resolve(false);  // Nome utente non valido
        } else {
            fetch("/signup/check/username", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token 
                },
                body: JSON.stringify({ username: username })
            })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    input.parentNode.querySelector('span').textContent = "Nome utente già in uso";
                    input.parentNode.classList.add('errorj');
                    resolve(false);  // Nome utente esistente
                } else {
                    input.parentNode.querySelector('span').textContent = "";
                    input.parentNode.classList.remove('errorj');
                    resolve(true);  // Nome utente valido
                }
            })
            .catch(error => {
                console.error('Error:', error);
                reject(error);  // Errore nella richiesta
            });
        }
    });
}

function checkEmail() {
    const emailInput = document.querySelector('.email input');
    const email = emailInput.value;
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    return new Promise((resolve, reject) => {
        if (!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email)) {
            document.querySelector('.email span').textContent = "Email non valida";
            document.querySelector('.email').classList.add('errorj');
            resolve(false);  // Email non valida
        } else {
            fetch("/signup/check/email", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({ email: email })
            })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    document.querySelector('.email span').textContent = "Email già in uso";
                    document.querySelector('.email').classList.add('errorj');
                    resolve(false);  // Email esistente
                } else {
                    document.querySelector('.email span').textContent = "";
                    document.querySelector('.email').classList.remove('errorj');
                    resolve(true);  // Email valida
                }
            })
            .catch(error => {
                console.error('Error:', error);
                reject(error);  // Errore nella richiesta
            });
        }
    });
}

function checkPassword(event) {
    const passwordInput = document.querySelector('.password input');

    if (formStatus.password = passwordInput.value.length >= 8) {
        document.querySelector('.password').classList.remove('errorj');
    } else {
        document.querySelector('.password').classList.add('errorj');
    }
}

function checkConfirmPassword(event) {
    const confirmPasswordInput = document.querySelector('.confirm_password input');

    if (formStatus.confirmPassword = confirmPasswordInput.value === document.querySelector('.password input').value) {
        document.querySelector('.confirm_password').classList.remove('errorj');
    } else {
        document.querySelector('.confirm_password').classList.add('errorj');
    }
}

function checkSignup(event) {
    const checkbox = document.querySelector('.allow input');
    formStatus[checkbox.name] = checkbox.checked;

    if (Object.keys(formStatus).length !== 8 || Object.values(formStatus).includes(false)) {
        event.preventDefault();
    }
}

// Seleziona il form
const form = document.forms['signup'];

form.addEventListener('submit', function(event) {
    event.preventDefault(); // Previene l'invio tradizionale del form

    Promise.all([checkUsername(), checkEmail()])
        .then(results => {
            const [isUsernameValid, isEmailValid] = results;

            if (isUsernameValid && isEmailValid ) {
                registerUser();
            } else {
                alert('Correggi i campi prima di procedere con la registrazione.');
            }
        })
        .catch(error => {
            console.error('Errore durante la verifica di email o username:', error);
            alert('Si è verificato un errore durante la verifica. Riprova.');
        });
});

function registerUser() {
    const form = document.querySelector('form');
    const formData = new FormData(form);
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('form/register', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            // 'Content-Type': 'application/json' // Non è necessario per FormData
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        console.log('Registrazione avvenuta con successo:', data);
        alert('Registrazione completata con successo!')
        window.location.href = 'home';
    })
    .catch(error => {
        console.error('Errore durante la registrazione:', error);
        alert('Si è verificato un errore durante la registrazione. Riprova.');
    });
}

const formStatus = { 'upload': true };

document.querySelector('.name input').addEventListener('blur', checkName);
document.querySelector('.surname input').addEventListener('blur', checkSurname);
document.querySelector('.username input').addEventListener('blur', checkUsername);
document.querySelector('.email input').addEventListener('blur', checkEmail);
document.querySelector('.password input').addEventListener('blur', checkPassword);
document.querySelector('.confirm_password input').addEventListener('blur', checkConfirmPassword);
document.querySelector('form').addEventListener('submit', checkSignup);
