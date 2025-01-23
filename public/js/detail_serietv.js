"use strict";

import { imageBaseURL, fetchDataFromServer } from "./api.js";
import { createSerieCard } from "./serie-card.js";
import { searchSerie } from "./search-serie.js";

const serieId = window.localStorage.getItem("serieId");

const pageContent = document.querySelector("[page-content]");

const getGenres = function (genreList) {
  const newGenreList = [];
  for (const { name } of genreList) newGenreList.push(name);
  return newGenreList.join(", ");
};

const getCreators = function (creatorsList) {
  const newCreatorsList = [];
  for (const { name } of creatorsList) newCreatorsList.push(name);
  return newCreatorsList.join(", ");
};

fetchDataFromServer("serietv/details?q=" + encodeURIComponent(serieId), function (serie) {
  const backdropPath = serie.backdrop_path;
  const posterPath = serie.poster_path;
  const name = serie.name;
  const firstAirDate = serie.first_air_date;
  const lastAirDate = serie.last_air_date;
  const episodeRunTime = serie.episode_run_time;
  const numberOfEpisodes = serie.number_of_episodes;
  const numberOfSeasons = serie.number_of_seasons;
  const voteAverage = serie.vote_average;
  const genres = serie.genres;
  const overview = serie.overview;
  const createdBy = serie.created_by;

  document.title = name + " - Netflix";

  const serieDetail = document.createElement("div");
  serieDetail.classList.add("serie-detail");

  const backdropImage = document.createElement("div");
  backdropImage.classList.add("backdrop-image");
  backdropImage.style.backgroundImage = "url('" + imageBaseURL + (backdropPath ? "w1280" : "original") + (backdropPath || posterPath) + "')";

  const figure = document.createElement("figure");
  figure.classList.add("poster-box", "serie-poster");

  const img = document.createElement("img");
  img.src = imageBaseURL + "w342" + posterPath;
  img.alt = name + "poster";
  img.classList.add("img-cover");
  figure.appendChild(img);

  const detailBox = document.createElement("div");
  detailBox.classList.add("detail-box");

  const detailContent = document.createElement("div");
  detailContent.classList.add("detail-content");

  const heading = document.createElement("h1");
  heading.classList.add("heading");
  heading.textContent = name;

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
  ratingSpan.textContent = voteAverage.toFixed(1);

  metaItemRating.appendChild(ratingImg);
  metaItemRating.appendChild(ratingSpan);

  const separator1 = document.createElement("div");
  separator1.classList.add("separator");

  const metaItemRuntime = document.createElement("div");
  metaItemRuntime.classList.add("meta-item");
  metaItemRuntime.textContent = (episodeRunTime && episodeRunTime.length > 0 ? episodeRunTime[0] : "N/A") + " min";

  const separator2 = document.createElement("div");
  separator2.classList.add("separator");

  const metaItemFirstAirDate = document.createElement("div");
  metaItemFirstAirDate.classList.add("meta-item");
  metaItemFirstAirDate.textContent = firstAirDate ? firstAirDate.split("-")[0] : "N/A";

  const metaItemLastAirDate = document.createElement("div");
  metaItemLastAirDate.classList.add("meta-item");
  metaItemLastAirDate.textContent = lastAirDate ? lastAirDate.split("-")[0] : "N/A";

  metaList.appendChild(metaItemRating);
  metaList.appendChild(separator1);
  metaList.appendChild(metaItemRuntime);
  metaList.appendChild(separator2);
  metaList.appendChild(metaItemFirstAirDate);
  metaList.appendChild(metaItemLastAirDate);

  const genreP = document.createElement("p");
  genreP.classList.add("genre");
  genreP.textContent = getGenres(genres);

  const overviewP = document.createElement("p");
  overviewP.classList.add("overview");
  overviewP.textContent = overview;

  const detailList = document.createElement("ul");
  detailList.classList.add("detail-list");

  const listItemCreatedBy = document.createElement("div");
  listItemCreatedBy.classList.add("list-item");

  const listNameCreatedBy = document.createElement("p");
  listNameCreatedBy.classList.add("list-name");
  listNameCreatedBy.textContent = "Creato Da";

  const listCreatedBy = document.createElement("p");
  listCreatedBy.textContent = getCreators(createdBy);

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

  const addToFavoritesButton = document.createElement("button");
  addToFavoritesButton.classList.add("add-to-favorites");
  addToFavoritesButton.textContent = "Aggiungi ai Preferiti";

  if (detailBox && detailContent) {
    detailBox.insertBefore(addToFavoritesButton, detailContent);
  } else {
    console.error("detailBox o detailContent non trovati");
  }

  let isAddedToFavorites = false;

  const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  function saveMovie() {
    const formData = new FormData();
    formData.append('serieId', serieId);
    formData.append('name', name);
    formData.append('first_air_date', first_air_date);
    formData.append('last_air_date', last_air_date);
    formData.append('episode_run_time', episode_run_time);
    formData.append('vote_average', vote_average);
    formData.append('genres', getGenres(genres));
    formData.append('created_by', getCreators(created_by)); // Usando la funzione per ottenere la stringa dei generi
    formData.append('overview', overview);
    formData.append('backdrop_path', backdrop_path);
    formData.append('poster_path', poster_path);

    const url = isAddedToFavorites ? "delete_movie" : "save_serie";
  
    fetch(url, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': token,
      },
      body: formData
    })
      .then(response => response.json())
      .then(data => {
        if (data.ok) {
          if (isAddedToFavorites) {
            addToFavoritesButton.textContent = "Aggiungi ai Preferiti";
          } else {
            addToFavoritesButton.textContent = "Aggiunto!";
          }
          isAddedToFavorites = !isAddedToFavorites; // Alterna lo stato
        } else {
          addToFavoritesButton.textContent = "Errore";
        }
      })
      .catch(error => {
        console.error('Errore:', error);
        addToFavoritesButton.textContent = "Errore";
      });
  }

  function checkIfSerieIsFavorited() {
    var userIdElement = document.getElementById('userId');
    var userId = userIdElement ? userIdElement.getAttribute('data-user-id') : null;
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const formData = new FormData();
    formData.append('serieId', serieId);
    formData.append('userId', userId);

    fetch("check_serie", {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': token,
      },
      body: formData
    })
      .then(response => response.json())
      .then(data => {
        if (data.isFavorited) {
          addToFavoritesButton.textContent = "Aggiunto!";
          isAddedToFavorites = true;
        } else {
          addToFavoritesButton.textContent = "Aggiungi ai Preferiti";
          isAddedToFavorites = false;
        }
      })
      .catch(error => {
        console.error('Errore:', error);
      });
  }

  addToFavoritesButton.addEventListener("click", function () {
    console.log("Button clicked!");
    saveMovie();
  });

  checkIfSerieIsFavorited();

  pageContent.appendChild(serieDetail);

  
  fetchDataFromServer("serietv/recommendations?sid=" + encodeURIComponent(serieId), addSuggestedSeries);
});

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

  for (const serie of serieList) {
    const serieCard = createSerieCard(serie);
    sliderInner.appendChild(serieCard);
  }

  pageContent.appendChild(serieListElem);
};

searchSerie();
