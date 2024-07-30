'use strict';
// URL base per le immagini
const imageBaseURL = 'https://image.tmdb.org/t/p/';

// Funzione per ottenere dati dal server
const fetchDataFromServer = function (url, callback, optionalParam) {
  fetch(url)
    .then(response => response.json())
    .then(data => callback(data, optionalParam));
}

// Esportazione delle costanti e della funzione
export { imageBaseURL, fetchDataFromServer };
