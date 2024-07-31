"use strict";

// Importa le costanti e funzioni necessarie da altri moduli
import { imageBaseURL, fetchDataFromServer } from "./api.js";
import { createSerieCard } from "./serie-card.js";
import { searchSerie } from "./search-serie.js";

// Recupera l'ID del film dal local storage
const serieId = window.localStorage.getItem("serieId");

// Seleziona l'elemento del contenuto della pagina
const pageContent = document.querySelector("[page-content]");

// Estrae e formatta i generi del film come stringa separata da virgole
function getGenres(genreList) {
  const newGenreList = [];
  console.log(genreList);
  for (const { name } of genreList) newGenreList.push(name);
  return newGenreList.join(", ");
};


// Recupera i dettagli del film dall'API di TMDB
fetchDataFromServer("serietv/details?q="+encodeURIComponent(serieId), function(serie) {
    const {
      backdrop_path,
      poster_path,
      name,
      number_of_episodes, //runtime
      number_of_seasons,//runtime,
      vote_average,
      genres,
      overview,
    } = serie;

    // Imposta il titolo della pagina
    document.name = `${name} - Netflix`;

    // Crea l'elemento principale dei dettagli del film
    const serieDetail = document.createElement("div");
    serieDetail.classList.add("serie-detail");

    // Crea e imposta l'immagine di sfondo
    const backdropImage = document.createElement("div");
    backdropImage.classList.add("backdrop-image");
    backdropImage.style.backgroundImage = `url('${imageBaseURL}${
      "w1280" || "original"
    }${backdrop_path || poster_path}')`;

    // Crea e imposta il poster del film
    const figure = document.createElement("figure");
    figure.classList.add("poster-box", "serie-poster");

    const img = document.createElement("img");
    img.src = `${imageBaseURL}w342${poster_path}`;
    img.alt = `${name} poster`;
    img.classList.add("img-cover");
    figure.appendChild(img);

    // Crea il contenitore dei dettagli del film
    const detailBox = document.createElement("div");
    detailBox.classList.add("detail-box");

    // Crea il contenuto dei dettagli 
    const detailContent = document.createElement("div");
    detailContent.classList.add("detail-content");

    // Imposta il titolo
    const heading = document.createElement("h1");
    heading.classList.add("heading");
    heading.textContent = name;

    // Crea e imposta i meta dati (valutazione, durata, data di rilascio, certificazione)
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
    ratingSpan.textContent = vote_average;

    metaItemRating.appendChild(ratingImg);
    metaItemRating.appendChild(ratingSpan);

    const separator1 = document.createElement("div");
    separator1.classList.add("separator");

    const metaItemNumber_of_episodes = document.createElement("div");
    metaItemNumber_of_episodes.classList.add("meta-item");
    metaItemNumber_of_episodes.textContent = `${number_of_episodes}m`;

    const separator2 = document.createElement("div");
    separator2.classList.add("separator");

    const metaItemNumber_of_seasons = document.createElement("div");
    metaItemNumber_of_seasons.classList.add("meta-item");
    metaItemNumber_of_seasons.textContent = `${number_of_seasons}m`;


    metaList.appendChild(metaItemRating);
    metaList.appendChild(separator1);
    metaList.appendChild(metaItemNumber_of_seasons);
    metaList.appendChild(separator2);
    metaList.appendChild(metaItemNumber_of_episodes);

    // Aggiunge il genere del film
    const genreP = document.createElement("p");
    genreP.classList.add("genre");
    genreP.textContent = getGenres(genres);

    // Aggiunge la descrizione del film
    const overviewP = document.createElement("p");
    overviewP.classList.add("overview");
    overviewP.textContent = overview;

    
    
    detailContent.appendChild(heading);
    detailContent.appendChild(metaList);
    detailContent.appendChild(genreP);
    detailContent.appendChild(overviewP);
    detailContent.appendChild(detailList);

    detailBox.appendChild(detailContent);

    const sliderList = document.createElement("div");
    sliderList.classList.add("slider-list");

    const sliderInner = document.createElement("div");
    sliderInner.classList.add("slider-inner");

    sliderList.appendChild(sliderInner);

    detailBox.appendChild(sliderList);

    serieDetail.appendChild(backdropImage);
    serieDetail.appendChild(figure);
    serieDetail.appendChild(detailBox);
    
    // Crea e aggiunge il bottone per aggiungere ai preferiti
    const addToFavoritesButton = document.createElement("button");
    addToFavoritesButton.classList.add("add-to-favorites");
    addToFavoritesButton.textContent = "Aggiungi ai Preferiti";
    
    // Verifica l'esistenza di detailBox e detailContent
    if (detailBox && detailContent) {
      detailBox.insertBefore(addToFavoritesButton, detailContent);
    } else {
      console.error("detailBox o detailContent non trovati");
    }
    
    // Variabile per tracciare se il film è nei preferiti
    let isAddedToFavorites = false;
    
    // Funzione per gestire il salvataggio del film
    function saveSerie() {
      // Prepara i dati da inviare al server
      const formData = new FormData();
      formData.append('serieId', serieId);
      formData.append('name', name);
      formData.append('first_air_date', first_air_date);
      formData.append('number_of_episodes', number_of_episodes);
      formData.append('number_of_seasons', number_of_seasons);
      formData.append('vote_average', vote_average);
      formData.append('genres', getGenres(genres)); // Usando la funzione per ottenere la stringa dei generi
      formData.append('overview', overview);
      formData.append('backdrop_path', backdrop_path);
      formData.append('poster_path', poster_path);
    
      const url = isAddedToFavorites ? "delete_serie" : "save_serie";
      // Controlla lo stato per determinare l'URL
    
      // Invia la richiesta al server
      fetch(url, {
        method: 'POST',
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
    
    // Funzione per inizializzare lo stato del bottone
    function checkIfSerieIsFavorited() {
      // Prepara i dati da inviare al server
      const formData = new FormData();
      formData.append('serieId', serieId);
    
      fetch("check_serie", {
        method: 'POST',
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
    
    // Aggiungi l'evento click al bottone
    addToFavoritesButton.addEventListener("click", function() {
      console.log("Button clicked!"); // Log per verificare il click
      saveSerie();
    });
    
    // Chiamata per verificare lo stato iniziale del film
    checkIfSerieIsFavorited();
    
    
    // Aggiunge i dettagli del film al contenuto della pagina
    pageContent.appendChild(serietvDetail);

    // Recupera e aggiunge i film suggeriti dall'API di TMDB
    fetchDataFromServer("serietv/recommendations?mid="+encodeURIComponent(serietvId), addSuggestedSerie);

  }
);

// Funzione per aggiungere i film suggeriti alla pagina
const addSuggestedSerie = function ({ results: serieList }, name) {

  const serieListElem = document.createElement("section");
  serieListElem.classList.add("serie-list");
  serieListElem.ariaLabel = "Potrebbe piacerti";

  const nameWrapper = document.createElement("div");
  nameWrapper.classList.add("name-wrapper");

  const nameLarge = document.createElement("h3");
  nameLarge.classList.add("name-large");
  nameLarge.textContent = "Potrebbe piacerti";

  nameWrapper.appendChild(nameLarge);

  const sliderList = document.createElement("div");
  sliderList.classList.add("slider-list");

  const sliderInner = document.createElement("div");
  sliderInner.classList.add("slider-inner");

  sliderList.appendChild(sliderInner);

  serieListElem.appendChild(nameWrapper);
  serieListElem.appendChild(sliderList);

  // Crea e aggiunge una scheda per ogni suggerito
  for ( const serie of serieList ) {
    const serieCard = createSerieCard(serie);
    sliderInner.appendChild(serieCard);
  }

  // Aggiunge la sezione dei film suggeriti al contenuto della pagina
  pageContent.appendChild(serieListElem);
};

// Richiama la funzione di ricerca
searchSerie();
