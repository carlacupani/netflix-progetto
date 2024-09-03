"use strict";

import { fetchDataFromServer } from "./api.js";

const pageContent = document.querySelector("[page-content]");

const createFavoriteMovieList = function (movies) {
  // Controllo se la lista dei film è vuota
  if (movies.length === 0) {
    const noFavoritesMessage = document.createElement("p");
    noFavoritesMessage.textContent = "Non ci sono ancora film preferiti"; // Mando questo messaggio solo se è vuota
    noFavoritesMessage.classList.add("title-large");
    pageContent.appendChild(noFavoritesMessage);
    return;
  }

  const movieListElem = document.createElement("section");
  movieListElem.classList.add("movie-list");
  movieListElem.ariaLabel = "Film preferiti";

  const titleWrapper = document.createElement("div");
  titleWrapper.classList.add("title-wrapper");

  const h3 = document.createElement("h3");
  h3.classList.add("title-large");
  h3.textContent = "Film preferiti"; // Titolo della sezione
  titleWrapper.appendChild(h3);

  movieListElem.appendChild(titleWrapper);

  const sliderList = document.createElement("div");
  sliderList.classList.add("slider-list");

  const sliderInner = document.createElement("div");
  sliderInner.classList.add("slider-inner");
  sliderList.appendChild(sliderInner);

  movieListElem.appendChild(sliderList);

  // Creazione delle card dei film per la sezione dei film preferiti
  for (const movie of movies) {
    // Verifica e aggiungi i campi mancanti con valori di default
    const movieData = movie.content;
    movieData.vote_average = movieData.vote_average !== undefined ? parseFloat(movieData.vote_average) : 0;
    movieData.release_date = movieData.release_date || "N/A";

    const movieCard = createMovieCard(movieData);
    sliderInner.appendChild(movieCard);
  }

  pageContent.appendChild(movieListElem);
};

fetchDataFromServer("favorite_movie", createFavoriteSerieList); 

