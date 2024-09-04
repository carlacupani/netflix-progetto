"use strict";

import { imageBaseURL, fetchDataFromServer } from "./api.js";
import { createSerieCard } from "./serie-card.js";
import { searchSerie } from "./search-serie.js";

const pageContent = document.querySelector("[page-content]");

/* 
  Creazione di un oggetto `genreList` per gestire i generi delle serie TV.
*/
const genreList = {
  asString(genreIdList) {
    let newGenreList = [];

    for (const genreId of genreIdList) {
      this[genreId] && newGenreList.push(this[genreId]);
    }

    return newGenreList.join(", ");
  },
};

fetch("/genre/serietv/list")
  .then((response) => response.json())
  .then((data) => {
    for (const { id, name } of data.genres) {
      genreList[id] = name;
    }
    
    fetchDataFromServer("/serietv/popular", heroBanner);
  })
  .catch((error) => console.error("Error:", error));

// Funzione per creare l'hero banner con le serie TV popolari
const heroBanner = function ({ results: serieList }) {
  const banner = document.createElement("section");
  banner.classList.add("banner");
  banner.ariaLabel = "Serie TV popolari";

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

  // Creazione degli elementi slider per ogni serie TV nella lista
  for (const [index, serie] of serieList.entries()) {
    const {
      backdrop_path,
      name, // Titolo della serie
      first_air_date, // Data di prima messa in onda
      genre_ids,
      overview,
      poster_path,
      vote_average,
      id,
    } = serie;

    const sliderItem = document.createElement("div");
    sliderItem.classList.add("slider-item");
    sliderItem.setAttribute("slider-item", "");

    // Crea e imposta l'immagine di sfondo per l'elemento slider
    const img = document.createElement("img");
    img.src = `${imageBaseURL}w1280${backdrop_path}`;
    img.alt = name;
    img.classList.add("img-cover");
    img.loading = index === 0 ? "eager" : "lazy"; // Il primo elemento viene caricato subito, gli altri lazy
    sliderItem.appendChild(img);

    // Crea e imposta il contenuto del banner
    const bannerContent = document.createElement("div");
    bannerContent.classList.add("banner-content");

    const h2 = document.createElement("h2");
    h2.classList.add("heading");
    h2.textContent = name;
    bannerContent.appendChild(h2);

    // Crea e imposta la lista dei meta dati della serie TV
    const metaList = document.createElement("div");
    metaList.classList.add("meta-list");

    const metaItemReleaseDate = document.createElement("div");
    metaItemReleaseDate.classList.add("meta-item");
    metaItemReleaseDate.textContent =
      first_air_date?.split("-")[0] ?? "Non rilasciato"; // Mostra l'anno di prima messa in onda
    metaList.appendChild(metaItemReleaseDate);

    const metaItemRating = document.createElement("div");
    metaItemRating.classList.add("meta-item", "card-badge");
    metaItemRating.textContent = vote_average.toFixed(1); // Arrotonda il voto medio a una cifra decimale
    metaList.appendChild(metaItemRating);

    bannerContent.appendChild(metaList);

    // Aggiunge il genere della serie TV
    const genreP = document.createElement("p");
    genreP.classList.add("genre");
    genreP.textContent = genreList.asString(genre_ids); // Converte gli ID dei generi in una stringa
    bannerContent.appendChild(genreP);

    // Aggiunge la descrizione della serie TV
    const bannerText = document.createElement("p");
    bannerText.classList.add("banner-text");
    bannerText.textContent = overview;
    bannerContent.appendChild(bannerText);

    // Crea e imposta il pulsante per accedere ai dettagli della serie TV
    const btn = document.createElement("a");
    btn.href = "details_serietv"; // Link ai dettagli della serie TV
    btn.classList.add("btn");
    btn.setAttribute("onclick", `getSerietvDetail(${id})`); // Funzione per ottenere i dettagli della serie TV

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

    // Crea il controllo dello slider per la navigazione tra le slide
    const controlItem = document.createElement("button");
    controlItem.classList.add("poster-box", "slider-item");
    controlItem.setAttribute("slider-control", `${controlItemIndex}`);
    controlItemIndex++;

    const controlItemImg = document.createElement("img");
    controlItemImg.src = `${imageBaseURL}w154${poster_path}`;
    controlItemImg.alt = `Slide to ${name}`;
    controlItemImg.loading = "lazy"; // Caricamento lazy delle immagini di controllo
    controlItemImg.draggable = false;
    controlItemImg.classList.add("img-cover");
    controlItem.appendChild(controlItemImg);

    controlInner.appendChild(controlItem);
  }

  // Aggiunge il banner alla pagina e inizializza lo slider
  pageContent.appendChild(banner);
  addHeroSlide();

  /* Fetch delle sezioni della homepage */
  // Recupera le serie TV in uscita, in tendenza questa settimana, e più votate
  fetchDataFromServer("/serietv/on_the_air", createSerieList, "In uscita");
  fetchDataFromServer("/trending/tv/week", createSerieList, "In tendenza questa settimana");
  fetchDataFromServer("/serietv/top_rated", createSerieList, "Più votati");
  fetchDataFromServer("/serietv/popular", createSerieList, "Più popolari tra i giovani");
};

// Funzione per aggiungere la funzionalità di slide all'hero banner
const addHeroSlide = function () {
  const sliderItems = document.querySelectorAll("[slider-item]");
  const sliderControls = document.querySelectorAll("[slider-control]");

  let lastSliderItem = sliderItems[0];
  let lastSliderControl = sliderControls[0];

  lastSliderItem.classList.add("active");
  lastSliderControl.classList.add("active");

  // Funzione per gestire il cambiamento di slide
  const sliderStart = function () {
    lastSliderItem.classList.remove("active");
    lastSliderControl.classList.remove("active");

    sliderItems[Number(this.getAttribute("slider-control"))].classList.add("active");
    this.classList.add("active");

    lastSliderItem = sliderItems[Number(this.getAttribute("slider-control"))];
    lastSliderControl = this;
  };

  // Aggiunge l'evento click ai controlli dello slider
  addEventOnElements(sliderControls, "click", sliderStart);
};

// Funzione per creare e aggiungere le card delle serie TV nelle sezioni della homepage
const createSerieList = function ({ results: serieList }, name) {
  const serieListElem = document.createElement("section");
  serieListElem.classList.add("serie-list");
  serieListElem.ariaLabel = `${name}`;

  const nameWrapper = document.createElement("div");
  nameWrapper.classList.add("name-wrapper");

  const h3 = document.createElement("h3");
  h3.classList.add("name-large");
  h3.textContent = name; // Titolo della sezione
  nameWrapper.appendChild(h3);

  serieListElem.appendChild(nameWrapper);

  const sliderList = document.createElement("div");
  sliderList.classList.add("slider-list");

  const sliderInner = document.createElement("div");
  sliderInner.classList.add("slider-inner");
  sliderList.appendChild(sliderInner);

  serieListElem.appendChild(sliderList);

  // Creazione delle card delle serie TV per la sezione
  for (const serie of serieList) {
    const serieCard = createSerieCard(serie);
    sliderInner.appendChild(serieCard);
  }

  // Aggiunge la sezione della lista delle serie TV al contenuto della pagina
  pageContent.appendChild(serieListElem);
};

// Avvia la ricerca delle serie TV
searchSerie();
