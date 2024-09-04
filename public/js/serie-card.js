"use strict";

import { imageBaseURL } from "./api.js";

export function createSerieCard(serie) {
  const { poster_path, name, vote_average, first_air_date, id } = serie;

  const card = document.createElement("div");
  card.classList.add("serie-card");

  const figure = document.createElement("figure");
  figure.classList.add("poster-box", "card-banner");
  
  const img = document.createElement("img");
  img.src = imageBaseURL + "w342" + poster_path;
  img.alt = name;
  img.classList.add("img-cover");
  img.loading = "lazy";
  
  figure.appendChild(img);
  card.appendChild(figure);

  const nameElem = document.createElement("h4");
  nameElem.classList.add("name");
  nameElem.textContent = name;
  card.appendChild(nameElem);

  const metaList = document.createElement("div");
  metaList.classList.add("meta-list");

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

  const cardBadge = document.createElement("div");
  cardBadge.classList.add("card-badge");
  cardBadge.textContent = first_air_date.split("-")[0];
  metaList.appendChild(cardBadge);

  card.appendChild(metaList);

  const anchor = document.createElement("a");
  anchor.href = "details_serietv";
  anchor.classList.add("card-btn");
  anchor.title = name;
  anchor.setAttribute("onclick", "getSerietvDetail(" + id + ")");
  
  card.appendChild(anchor);

  return card;
}
