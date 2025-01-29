"use strict";

const imageBaseURL = 'https://image.tmdb.org/t/p/';

export function createSerieCard(serie) {
  const posterPath = serie.poster_path;
  const name = serie.name;
  const serieId = serie.id;

  const card = document.createElement("div");
  card.classList.add("serie-card");

  const figure = document.createElement("figure");
  figure.classList.add("poster-box", "card-banner");
  
  const img = document.createElement("img");
  img.src = imageBaseURL + "w342" + posterPath;
  img.classList.add("img-cover");
  img.loading = "lazy";
  
  figure.appendChild(img);
  card.appendChild(figure);
  
  const anchor = document.createElement("a");
  anchor.href = "serietv/details" + serieId;
  anchor.classList.add("card-btn");
  anchor.title = name;
  
  card.appendChild(anchor);

  return card;
}
