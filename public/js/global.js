"use strict";

/* Funzione per aggiungere un evento a una lista di lementi
const addEventOnElements = function (elements, eventType, callback) {
  for (const elem of elements) 
    elem.addEventListener(eventType, callback);
};
*/

const searchBox = document.querySelector("[search-box]");

const searchTogglers = document.querySelectorAll("[search-toggler]");

searchTogglers.forEach(function (toggler) {
  toggler.addEventListener("click", function () {
    searchBox.classList.toggle("active");
  });
});

const getMovieDetail = function (movieId) {
  window.localStorage.setItem("movieId", String(movieId));
};

const getMovieList = function (urlParam, genreName) {
  window.localStorage.setItem("urlParam", urlParam);
  window.localStorage.setItem("genreName", genreName);
};

const getSerietvDetail = function (serieId) {
  window.localStorage.setItem("serieId", String(serieId));
};

const getSerieList = function (urlParam, genreName) {
  window.localStorage.setItem("urlParam", urlParam);
  window.localStorage.setItem("genreName", genreName);
};
