"use strict";
/* Importazione di tutte le componenti e funzioni */

import { imageBaseURL, fetchDataFromServer } from "./api.js";
import { createMovieCard } from "./movie-card.js";
import { searchMovie } from "./search-movie.js";

const pageContent = document.querySelector("[page-content]");

/* Fetch di tutti i generi es: [ { "id": "123", "name": "Action" } ]
   poi cambia il formato del genere es: { 123: "Action" } */
const genreList = {
  // crea una stringa di generi a partire dagli id dei generi es: [23, 43] -> "Action, Romance".
  asString(genreIdList) {
    let newGenreList = [];

    for (const genreId of genreIdList) {
      this[genreId] && newGenreList.push(this[genreId]);
    }

    return newGenreList.join(", ");
  },
};

// Fetch della lista dei generi dal server
fetch("/genre/movie/list")
  .then((response) => response.json())
  .then((data) => {
    // Popolazione della lista dei generi con i dati ricevuti dal server
    for (const { id, name } of data.genres) {
      genreList[id] = name;
    }
    fetchDataFromServer("/movie/popular", heroBanner);
})
  .catch((error) => console.error("Error:", error));

// Funzione per creare l'hero banner con i film popolari
const heroBanner = function ({ results: movieList }) {
  const banner = document.createElement("section");
  banner.classList.add("banner");
  banner.ariaLabel = "Film popolari";

  const bannerSlider = document.createElement("div");
  bannerSlider.classList.add("banner-slider");
  banner.appendChild(bannerSlider);

  const sliderControl = document.createElement("div");
  sliderControl.classList.add("slider-control");

  const controlInner = document.createElement("div");
  controlInner.classList.add("control-inner");
  sliderControl.appendChild(controlInner);

  banner.appendChild(sliderControl);

  let controlItemIndex = 0;

  // Creazione degli elementi slider per ogni film nella lista
  for (const [index, movie] of movieList.entries()) {
    const {
      backdrop_path,
      title,
      release_date,
      genre_ids,
      overview,
      poster_path,
      vote_average,
      id,
    } = movie;

    const sliderItem = document.createElement("div");
    sliderItem.classList.add("slider-item");
    sliderItem.setAttribute("slider-item", "");

    const img = document.createElement("img");
    img.src = `${imageBaseURL}w1280${backdrop_path}`;
    img.alt = title;
    img.classList.add("img-cover");
    img.loading = index === 0 ? "eager" : "lazy"; // Il primo elemento viene caricato subito, gli altri lazy
    sliderItem.appendChild(img);

    const bannerContent = document.createElement("div");
    bannerContent.classList.add("banner-content");

    const h2 = document.createElement("h2");
    h2.classList.add("heading");
    h2.textContent = title;
    bannerContent.appendChild(h2);

    const metaList = document.createElement("div");
    metaList.classList.add("meta-list");

    const metaItemReleaseDate = document.createElement("div");
    metaItemReleaseDate.classList.add("meta-item");
    metaItemReleaseDate.textContent =
      release_date?.split("-")[0] ?? "Not Released"; // Mostra solo l'anno di uscita
    metaList.appendChild(metaItemReleaseDate);

    const metaItemRating = document.createElement("div");
    metaItemRating.classList.add("meta-item", "card-badge");
    metaItemRating.textContent = vote_average.toFixed(1); // Arrotonda il voto medio a una cifra decimale
    metaList.appendChild(metaItemRating);

    bannerContent.appendChild(metaList);

    const genreP = document.createElement("p");
    genreP.classList.add("genre");
    genreP.textContent = genreList.asString(genre_ids); // Converte gli id dei generi in una stringa
    bannerContent.appendChild(genreP);

    const bannerText = document.createElement("p");
    bannerText.classList.add("banner-text");
    bannerText.textContent = overview; // Descrizione del film
    bannerContent.appendChild(bannerText);

    const btn = document.createElement("a");
    btn.href = "details_movie"; // Link ai dettagli del film
    btn.classList.add("btn");
    btn.setAttribute("onclick", `getMovieDetail(${id})`); // Funzione per ottenere i dettagli del film

    const playCircleImg = document.createElement("img");
    playCircleImg.src = "./images/play_circle.png";
    playCircleImg.width = 24;
    playCircleImg.height = 24;
    playCircleImg.ariaHidden = "true";
    playCircleImg.alt = "play circle";
    btn.appendChild(playCircleImg);

    const span = document.createElement("span");
    span.classList.add("span");
    span.textContent = "Riproduci";
    btn.appendChild(span);

    bannerContent.appendChild(btn);

    sliderItem.appendChild(bannerContent);
    bannerSlider.appendChild(sliderItem);

    const controlItem = document.createElement("button");
    controlItem.classList.add("poster-box", "slider-item");
    controlItem.setAttribute("slider-control", `${controlItemIndex}`);
    controlItemIndex++;

    const controlItemImg = document.createElement("img");
    controlItemImg.src = `${imageBaseURL}w154${poster_path}`;
    controlItemImg.alt = `Slide to ${title}`;
    controlItemImg.loading = "lazy"; // Caricamento lazy delle immagini di controllo
    controlItemImg.draggable = false;
    controlItemImg.classList.add("img-cover");
    controlItem.appendChild(controlItemImg);

    controlInner.appendChild(controlItem);
  }

  pageContent.appendChild(banner);
  addHeroSlide(); // Aggiunta della funzionalità di slide all'hero banner
  
  /* Sezioni della homepage (Top rated, Upcoming, Trending movies) */
  // Fetch delle sezioni della homepage (In uscita, In tendenza questa settimana, Più votati)
  fetchDataFromServer("/movie/upcoming", createMovieList, "In uscita");
  fetchDataFromServer("/trending/movie/week", createMovieList, "In tendenza questa settimana");
  fetchDataFromServer("/movie/top_rated", createMovieList, "Più votati");
  fetchDataFromServer("/movie/popular", createMovieList, "Più popolari tra i giovani");

};

// Funzione per aggiungere lo slide all'hero banner
const addHeroSlide = function () {
  const sliderItems = document.querySelectorAll("[slider-item]");
  const sliderControls = document.querySelectorAll("[slider-control]");

  let lastSliderItem = sliderItems[0];
  let lastSliderControl = sliderControls[0];

  lastSliderItem.classList.add("active");
  lastSliderControl.classList.add("active");

  const sliderStart = function () {
    lastSliderItem.classList.remove("active");
    lastSliderControl.classList.remove("active");

    sliderItems[Number(this.getAttribute("slider-control"))].classList.add(
      "active"
    );
    this.classList.add("active");

    lastSliderItem = sliderItems[Number(this.getAttribute("slider-control"))];
    lastSliderControl = this;
  };

  addEventOnElements(sliderControls, "click", sliderStart); // Aggiunta dell'evento click per il controllo dello slide
};

// Funzione per creare la lista dei film nelle sezioni della homepage
const createMovieList = function ({ results: movieList }, title) {
  const movieListElem = document.createElement("section");
  movieListElem.classList.add("movie-list");
  movieListElem.ariaLabel = `${title}`;

  const titleWrapper = document.createElement("div");
  titleWrapper.classList.add("title-wrapper");

  const h3 = document.createElement("h3");
  h3.classList.add("title-large");
  h3.textContent = title; // Titolo della sezione
  titleWrapper.appendChild(h3);

  movieListElem.appendChild(titleWrapper);

  const sliderList = document.createElement("div");
  sliderList.classList.add("slider-list");

  const sliderInner = document.createElement("div");
  sliderInner.classList.add("slider-inner");
  sliderList.appendChild(sliderInner);

  movieListElem.appendChild(sliderList);

  // Creazione delle card dei film per la sezione
  for (const movie of movieList) {
    const movieCard = createMovieCard(movie);
    sliderInner.appendChild(movieCard);
  }

  pageContent.appendChild(movieListElem);
};

searchMovie();