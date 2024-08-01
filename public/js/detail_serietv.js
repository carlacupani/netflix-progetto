"use strict";

// Importa le costanti e funzioni necessarie da altri moduli
import { imageBaseURL, fetchDataFromServer } from "./api.js";
import { createSerieCard } from "./serie-card.js";
import { searchSerie } from "./search-serie.js";

// Recupera l'ID della serie dal local storage
const serieId = window.localStorage.getItem("serieId");

// Seleziona l'elemento del contenuto della pagina
const pageContent = document.querySelector("[page-content]");
// Estrae e formatta i generi del film come stringa separata da virgole
const getGenres = function (genreList) {
  const newGenreList = [];

  for (const { name } of genreList) newGenreList.push(name);

  return newGenreList.join(", ");
};

// Estrae e formatta i generi della serie come stringa separata da virgole
const getCreators = function (creatorsList) {
  const newCreatorsList = [];

  for (const { name } of creatorsList) newCreatorsList.push(name);

  return newCreatorsList.join(", ");
};

// Recupera i dettagli della serie dall'API
fetchDataFromServer(`serietv/details?q=${encodeURIComponent(serieId)}`, function (serie) {
  const {
    backdrop_path,
    poster_path,
    name,
    first_air_date,
    last_air_date,
    episode_run_time,
    number_of_episodes,
    number_of_seasons,
    vote_average,
    genres,
    overview,
    created_by,
  } = serie;

  // Imposta il titolo della pagina
  document.title = `${name} - Netflix`;

  // Crea l'elemento principale dei dettagli della serie
  const serieDetail = document.createElement("div");
  serieDetail.classList.add("serie-detail");

  // Crea e imposta l'immagine di sfondo
  const backdropImage = document.createElement("div");
  backdropImage.classList.add("backdrop-image");
  backdropImage.style.backgroundImage = `url('${imageBaseURL}${backdrop_path ? "w1280" : "original"}${backdrop_path || poster_path}')`;

  // Crea e imposta il poster della serie
  const figure = document.createElement("figure");
  figure.classList.add("poster-box", "serie-poster");

  const img = document.createElement("img");
  img.src = `${imageBaseURL}w342${poster_path}`;
  img.alt = `${name} poster`;
  img.classList.add("img-cover");
  figure.appendChild(img);

  // Crea il contenitore dei dettagli della serie
  const detailBox = document.createElement("div");
  detailBox.classList.add("detail-box");

  // Crea il contenuto dei dettagli della serie
  const detailContent = document.createElement("div");
  detailContent.classList.add("detail-content");

  // Imposta il titolo della serie
  const heading = document.createElement("h1");
  heading.classList.add("heading");
  heading.textContent = name;

  // Crea e imposta i meta dati della serie (valutazione, durata, data di rilascio)
  const metaList = document.createElement("div");
  metaList.classList.add("meta-list");

  const metaItemRating = document.createElement("div");
  metaItemRating.classList.add("meta-item");

  const ratingImg = document.createElement("img");
  ratingImg.src = "./images/star.png";
  ratingImg.width = 20;
  ratingImg.height = 20;
  ratingImg.alt = "rating";

  const ratingSpan = document.createElement("span");
  ratingSpan.classList.add("span");
  // Verifica se `vote_average` è definito e numerico prima di chiamare `toFixed`
  ratingSpan.textContent = (vote_average != null && !isNaN(vote_average)) ? vote_average.toFixed(1) : "N/A";


  metaItemRating.appendChild(ratingImg);
  metaItemRating.appendChild(ratingSpan);

  const separator1 = document.createElement("div");
  separator1.classList.add("separator");

  const metaItemRuntime = document.createElement("div");
  metaItemRuntime.classList.add("meta-item");
  metaItemRuntime.textContent = `${episode_run_time && episode_run_time.length > 0 ? episode_run_time[0] : "N/A"} min`;

  const separator2 = document.createElement("div");
  separator2.classList.add("separator");

  const metaItemFirstAirDate = document.createElement("div");
  metaItemFirstAirDate.classList.add("meta-item");
  metaItemFirstAirDate.textContent = first_air_date ? first_air_date.split("-")[0] : "N/A";

  const metaItemLastAirDate = document.createElement("div");
  metaItemLastAirDate.classList.add("meta-item");
  metaItemLastAirDate.textContent = last_air_date ? last_air_date.split("-")[0] : "N/A";

  metaList.appendChild(metaItemRating);
  metaList.appendChild(separator1);
  metaList.appendChild(metaItemRuntime);
  metaList.appendChild(separator2);
  metaList.appendChild(metaItemFirstAirDate);
  metaList.appendChild(metaItemLastAirDate);

  // Aggiunge il genere della serie
  const genreP = document.createElement("p");
  genreP.classList.add("genre");
  genreP.textContent = getGenres(genres);

  // Aggiunge la descrizione della serie
  const overviewP = document.createElement("p");
  overviewP.classList.add("overview");
  overviewP.textContent = overview;

  // Aggiunge i dettagli della serie
  const detailList = document.createElement("ul");
  detailList.classList.add("detail-list");

  const listItemCreatedBy = document.createElement("div");
  listItemCreatedBy.classList.add("list-item");

  const listNameCreatedBy = document.createElement("p");
  listNameCreatedBy.classList.add("list-name");
  listNameCreatedBy.textContent = "Creato Da";

  const listCreatedBy = document.createElement("p");
  listCreatedBy.textContent = getCreators(created_by);

  listItemCreatedBy.appendChild(listNameCreatedBy);
  listItemCreatedBy.appendChild(listCreatedBy);

  detailList.appendChild(listItemCreatedBy);

  detailContent.appendChild(heading);
  detailContent.appendChild(metaList);
  detailContent.appendChild(genreP);
  detailContent.appendChild(overviewP);
  detailContent.appendChild(detailList);

  detailBox.appendChild(detailContent);

  serieDetail.appendChild(backdropImage);
  serieDetail.appendChild(figure);
  serieDetail.appendChild(detailBox);

  // Aggiunge i dettagli della serie al contenuto della pagina
  pageContent.appendChild(serieDetail);

  // Recupera e aggiunge le serie suggerite dall'API
  fetchDataFromServer(`serietv/recommendations?sid=${encodeURIComponent(serieId)}`, addSuggestedSeries);
});

// Funzione per aggiungere le serie suggerite alla pagina
const addSuggestedSeries = function ({ results: serieList }) {
  const serieListElem = document.createElement("section");
  serieListElem.classList.add("serie-list");
  serieListElem.ariaLabel = "Potrebbe piacerti";

  const titleWrapper = document.createElement("div");
  titleWrapper.classList.add("name-wrapper");

  const titleLarge = document.createElement("h3");
  titleLarge.classList.add("name-large");
  titleLarge.textContent = "Potrebbe piacerti";

  titleWrapper.appendChild(titleLarge);

  const sliderList = document.createElement("div");
  sliderList.classList.add("slider-list");

  const sliderInner = document.createElement("div");
  sliderInner.classList.add("slider-inner");

  sliderList.appendChild(sliderInner);

  serieListElem.appendChild(titleWrapper);
  serieListElem.appendChild(sliderList);

  // Crea e aggiunge una scheda per ogni serie suggerita
  for (const serie of serieList) {
    const serieCard = createSerieCard(serie);
    sliderInner.appendChild(serieCard);
  }

  // Aggiunge la sezione delle serie suggerite al contenuto della pagina
  pageContent.appendChild(serieListElem);
};

// Richiama la funzione di ricerca
searchSerie();
