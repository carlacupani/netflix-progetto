# Netflix Clone

Clone di Netflix sviluppato per un progetto universitario. Questo progetto è una replica del famoso servizio di streaming, progettato per dimostrare competenze in sviluppo web utilizzando Laravel.

## Descrizione

Questo progetto è un clone di Netflix, realizzato come parte di un progetto accademico. L'obiettivo è riprodurre alcune delle funzionalità principali di Netflix, come la visualizzazione di film e serie TV, la gestione degli utenti. È stato sviluppato utilizzando il framework PHP Laravel e altri strumenti moderni di sviluppo web.

## Funzionalità

Il clone di Netflix include le seguenti funzionalità:

- **Visualizzare film e serie TV:** Gli utenti possono navigare e visualizzare una vasta gamma di film e serie TV disponibili.
- **Visualizzare i dettagli di film e serie TV:** Ogni film e serie TV ha una pagina dedicata che mostra i dettagli come il titolo, la descrizione, il genere, la durata, il cast e altro.
- **Aggiungere o rimuovere film e serie TV dai preferiti:** Gli utenti possono aggiungere film e serie TV alla loro lista di preferiti e rimuoverli quando lo desiderano.
- **Visualizzare la lista dei preferiti nella pagina del profilo:** Gli utenti possono accedere alla loro pagina profilo per vedere tutti i film e le serie TV che hanno aggiunto ai preferiti.
- **Modificare i dati del profilo:** Gli utenti possono aggiornare le informazioni del proprio profilo, come il nome, il cognome, l'username, l'email e la password.
- **Integrazione con TMDB:** L'applicazione utilizza le API di TMDB per ottenere informazioni su film e serie TV. Le chiavi API per accedere a TMDB sono configurabili nel file `.env`.

## Prerequisiti

Assicurati di avere i seguenti strumenti installati prima di procedere con l'installazione:

- PHP >= 8.0
- Composer
- MySQL
- [TMDB API Key](https://www.themoviedb.org/settings/api)

## Installazione

Segui questi passaggi per configurare l'ambiente di sviluppo e avviare il progetto.

### Clonare il repository:
    ```bash
    git clone https://github.com/carlacupani/netflix-progetto.git
    cd netflix-progetto

### Installare le dipendenze PHP e JavaScript:
    composer install
    npm install
    npm run dev

### Configurare l'ambiente:
    cp .env.example .env

### Migrare il database:
    php artisan migrate

### Avviare il server di sviluppo
    php artisan serve
L'applicazione sarà accessibile su http://localhost:8000.

## Contatti
Per qualsiasi domanda o suggerimento, puoi contattarmi via email: cpnclp00@example.com


