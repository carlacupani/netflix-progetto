"use strict";

import { fetchDataFromServer } from "./api.js";
import {createMovieCard} from "./movie-card.js"
import {createSerieCard} from "./serie-card.js"

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

    
    movie.vote_average = movie.vote_average !== undefined ? parseFloat(movie.vote_average) : 0;
    movie.release_date = movie.release_date || "N/A";
    
    if(movie.isSerie == 1){

      const serieCard = createSerieCard(movie);
      sliderInner.appendChild(serieCard);

    }else{

      const movieCard = createMovieCard(movie);
      sliderInner.appendChild(movieCard);
      
    }

  }

  pageContent.appendChild(movieListElem);
};

// Fetch dei film preferiti dal server
fetch("favorite_movie")
  .then((response) => response.json())
  .then((data) => {
    // Popolazione della lista dei generi con i dati ricevuti dal server
    console.log(data.films);
    createFavoriteMovieList(data.films);
})
  .catch((error) => console.error("Error:", error)); 

