"use strict";

import {createMovieCard} from "./movie-card.js"
//import {createSerieCard} from "./serie-card.js"

const pageContent = document.querySelector(".container");

const createFavoriteMovieList = function (movies) {
  if (movies.length === 0) {
    const noFavoritesMessage = document.createElement("p");
    noFavoritesMessage.textContent = "Non hai aggiunto preferiti"; // Mando questo messaggio solo se è vuota
    noFavoritesMessage.classList.add("title-large");
    pageContent.appendChild(noFavoritesMessage);
    return;
  }
  const movieListElem = document.createElement("section");
  movieListElem.classList.add("movie-list");

  const titleWrapper = document.createElement("div");
  titleWrapper.classList.add("title-wrapper");

  const h3 = document.createElement("h3");
  h3.classList.add("title-large");
  h3.textContent = "La mia lista";
  titleWrapper.appendChild(h3);

  movieListElem.appendChild(titleWrapper);

  const sliderList = document.createElement("div");
  sliderList.classList.add("slider-list");

  const sliderInner = document.createElement("div");
  sliderInner.classList.add("slider-inner");
  sliderList.appendChild(sliderInner);

  movieListElem.appendChild(sliderList);

  for (const movie of movies) {
      const movieCard = createMovieCard(movie);
      sliderInner.appendChild(movieCard);
  }
  pageContent.appendChild(movieListElem);
};

fetch("favorite_movie")
  .then((response) => response.json())
  .then((data) => {
    //console.log(data.films);
    createFavoriteMovieList(data.films);
})
  .catch((error) => console.error("Error:", error)); 
