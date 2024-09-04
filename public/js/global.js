"use strict";

// Funzione per aggiungere un evento a una lista di elementi
const addEventOnElements = function (elements, eventType, callback) {
  for (const elem of elements) 
    elem.addEventListener(eventType, callback);
};

// Seleziona la casella di ricerca
const searchBox = document.querySelector("[search-box]");

// Seleziona tutti i toggler della ricerca (i pulsanti per aprire/chiudere la casella di ricerca)
const searchTogglers = document.querySelectorAll("[search-toggler]");

// Aggiunge un evento di clic a tutti i toggler della ricerca
addEventOnElements(searchTogglers, "click", function () {
  searchBox.classList.toggle("active");
});

// Funzione per memorizzare l'ID del film nel local storage
const getMovieDetail = function (movieId) {
  window.localStorage.setItem("movieId", String(movieId));
};

// Funzione per memorizzare l'URL della richiesta e il nome del genere nel local storage
const getMovieList = function (urlParam, genreName) {
  window.localStorage.setItem("urlParam", urlParam);
  window.localStorage.setItem("genreName", genreName);
};

const getSerietvDetail = function (serieId) {
  window.localStorage.setItem("serieId", String(serieId));
};

// Funzione per memorizzare l'URL della richiesta e il nome del genere nel local storage
const getSerieList = function (urlParam, genreName) {
  window.localStorage.setItem("urlParam", urlParam);
  window.localStorage.setItem("genreName", genreName);
};
