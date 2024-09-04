"use strict";

import { imageBaseURL } from "./api.js";

export function createMovieCard(movie) {
  const { poster_path, title, vote_average, release_date, movieId } = movie;

  const card = document.createElement("div");
  card.classList.add("movie-card");

  // Crea il contenitore figure e img per il poster
  const figure = document.createElement("figure");
  figure.classList.add("poster-box", "card-banner");

  const img = document.createElement("img");
  img.src = `${imageBaseURL}w342${poster_path}`;
  img.alt = title;
  img.classList.add("img-cover");
  img.loading = "lazy";

  figure.appendChild(img);
  card.appendChild(figure);

  // Crea il titolo
  const titleElem = document.createElement("h4");
  titleElem.classList.add("title");
  titleElem.textContent = title;
  card.appendChild(titleElem);

  // Crea la la lista
  const metaList = document.createElement("div");
  metaList.classList.add("meta-list");

  // Crea l'elemento per la valutazione
  const metaItem = document.createElement("div");
  metaItem.classList.add("meta-item");

  const ratingImg = document.createElement("img");
  ratingImg.src = "./images/star.png";
  ratingImg.width = 20;
  ratingImg.height = 20;
  ratingImg.loading = "lazy";
  ratingImg.alt = "rating";

  const ratingSpan = document.createElement("span");
  ratingSpan.classList.add("span");
  ratingSpan.textContent = vote_average.toFixed(1);

  metaItem.appendChild(ratingImg);
  metaItem.appendChild(ratingSpan);
  metaList.appendChild(metaItem);

  // Crea il badge per la data di rilascio
  const cardBadge = document.createElement("div");
  cardBadge.classList.add("card-badge");
  cardBadge.textContent = release_date.split("-")[0];
  metaList.appendChild(cardBadge);

  card.appendChild(metaList);

  //Crea il link per i dettagli
  const anchor = document.createElement("a");
  anchor.href = "details_movie";
  anchor.classList.add("card-btn");
  anchor.title = title;
  anchor.setAttribute("onclick", "getMovieDetail(" + id + ")");

  card.appendChild(anchor);
  

  return card;
}
