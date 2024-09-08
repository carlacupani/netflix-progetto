"use strict";

import { imageBaseURL, fetchDataFromServer } from "./api.js";
import { createMovieCard } from "./movie-card.js";
import { searchMovie } from "./search-movie.js";

const movieId = window.localStorage.getItem("movieId");

const pageContent = document.querySelector("[page-content]");

const getGenres = function (genreList) {
  const newGenreList = [];

  for (const { name } of genreList) newGenreList.push(name);

  return newGenreList.join(", ");
};

const getCasts = function (castList) {
  const newCastList = [];

  for (let i = 0, len = castList.length; i < len && i < 10; i++) {
    const { name } = castList[i];
    newCastList.push(name);
  }

  return newCastList.join(", ");
};

const getDirectors = function (crewList) {
  const directors = crewList.filter(({ job }) => job === "Director");

  const directorList = [];
  for (const { name } of directors) directorList.push(name);

  return directorList.join(", ");
};

const filterVideos = function (videoList) {
  return videoList.filter(
    ({ type, site }) =>
      (type === "Trailer" || type === "Teaser") && site === "YouTube"
  );
};



fetchDataFromServer("movie/details?q="+encodeURIComponent(movieId), function(movie) {
    const {
      backdrop_path,
      poster_path,
      title,
      release_date,
      runtime,
      vote_average,
      releases: {
        countries: [{ certification } = { certification: "N/A" }],
      },
      genres,
      overview,
      casts: { cast, crew },
      videos: { results: videos },
    } = movie;

    document.title = ' " ' + title + ' - Netflix"';

    const movieDetail = document.createElement("div");
    movieDetail.classList.add("movie-detail");

    const backdropImage = document.createElement("div");
    backdropImage.classList.add("backdrop-image");
    backdropImage.style.backgroundImage = `url('${imageBaseURL}${
      "w1280" || "original"
    }${backdrop_path || poster_path}')`;

    const figure = document.createElement("figure");
    figure.classList.add("poster-box", "movie-poster");

    const img = document.createElement("img");
    img.src = `${imageBaseURL}w342${poster_path}`;
    img.alt = `${title} poster`;
    img.classList.add("img-cover");
    figure.appendChild(img);

    const detailBox = document.createElement("div");
    detailBox.classList.add("detail-box");

    const detailContent = document.createElement("div");
    detailContent.classList.add("detail-content");

    const heading = document.createElement("h1");
    heading.classList.add("heading");
    heading.textContent = title;

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
    ratingSpan.textContent = vote_average.toFixed(1);

    metaItemRating.appendChild(ratingImg);
    metaItemRating.appendChild(ratingSpan);

    const separator1 = document.createElement("div");
    separator1.classList.add("separator");

    const metaItemRuntime = document.createElement("div");
    metaItemRuntime.classList.add("meta-item");
    metaItemRuntime.textContent = `${runtime}m`;

    const separator2 = document.createElement("div");
    separator2.classList.add("separator");

    const metaItemReleaseDate = document.createElement("div");
    metaItemReleaseDate.classList.add("meta-item");
    metaItemReleaseDate.textContent = release_date?.split("-")[0] ?? "Non rilasciato";

    const cardBadge = document.createElement("div");
    cardBadge.classList.add("meta-item", "card-badge");
    cardBadge.textContent = certification;

    metaList.appendChild(metaItemRating);
    metaList.appendChild(separator1);
    metaList.appendChild(metaItemRuntime);
    metaList.appendChild(separator2);
    metaList.appendChild(metaItemReleaseDate);
    metaList.appendChild(cardBadge);

    const genreP = document.createElement("p");
    genreP.classList.add("genre");
    genreP.textContent = getGenres(genres);

    const overviewP = document.createElement("p");
    overviewP.classList.add("overview");
    overviewP.textContent = overview;

    const detailList = document.createElement("ul");
    detailList.classList.add("detail-list");

    const listItemCast = document.createElement("div");
    listItemCast.classList.add("list-item");

    const listNameCast = document.createElement("p");
    listNameCast.classList.add("list-name");
    listNameCast.textContent = "Cast";

    const listCast = document.createElement("p");
    listCast.textContent = getCasts(cast);

    listItemCast.appendChild(listNameCast);
    listItemCast.appendChild(listCast);

    const listItemDirector = document.createElement("div");
    listItemDirector.classList.add("list-item");

    const listNameDirector = document.createElement("p");
    listNameDirector.classList.add("list-name");
    listNameDirector.textContent = "Diretto Da";

    const listDirector = document.createElement("p");
    listDirector.textContent = getDirectors(crew);

    listItemDirector.appendChild(listNameDirector);
    listItemDirector.appendChild(listDirector);

    detailList.appendChild(listItemCast);
    detailList.appendChild(listItemDirector);

    detailContent.appendChild(heading);
    detailContent.appendChild(metaList);
    detailContent.appendChild(genreP);
    detailContent.appendChild(overviewP);
    detailContent.appendChild(detailList);

    detailBox.appendChild(detailContent);

    // Crea l'intestazione per i trailer e le clip
    const titleWrapper = document.createElement("div");
    titleWrapper.classList.add("title-wrapper");

    const titleLarge = document.createElement("h3");
    titleLarge.classList.add("title-large");
    titleLarge.textContent = "Trailers e Clips";

    titleWrapper.appendChild(titleLarge);

    const sliderList = document.createElement("div");
    sliderList.classList.add("slider-list");

    const sliderInner = document.createElement("div");
    sliderInner.classList.add("slider-inner");

    sliderList.appendChild(sliderInner);

    detailBox.appendChild(titleWrapper);
    detailBox.appendChild(sliderList);

    movieDetail.appendChild(backdropImage);
    movieDetail.appendChild(figure);
    movieDetail.appendChild(detailBox);
    
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
    function saveMovie() {
      // Prepara i dati da inviare al server

      const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      const formData = new FormData();
      formData.append('movieId', movieId);
      formData.append('title', title);
      formData.append('release_date', release_date);
      formData.append('runtime', runtime);
      formData.append('vote_average', vote_average);
      formData.append('genres', getGenres(genres)); // Usando la funzione per ottenere la stringa dei generi
      formData.append('overview', overview);
      formData.append('backdrop_path', backdrop_path);
      formData.append('poster_path', poster_path);
    
      const url = isAddedToFavorites ? "delete_movie" : "save_movie";

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
    
    function checkIfMovieIsFavorited() {
      // Prepara i dati da inviare al server
      var userIdElement = document.getElementById('userId');
      var userId = userIdElement ? userIdElement.getAttribute('data-user-id') : null;
      const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      const formData = new FormData();
      formData.append('movieId', movieId);
      formData.append('userId', userId);

    
      fetch("check_movie", {
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
    
    addToFavoritesButton.addEventListener("click", function() {
      console.log("Button clicked!"); // Log per verificare il click
      saveMovie();
    });
    
    checkIfMovieIsFavorited();
    
    for (const { key, name } of filterVideos(videos)) {
      const videoCard = document.createElement("div");
      videoCard.classList.add("video-card");

      const iframe = document.createElement("iframe");
      iframe.width = "500";
      iframe.height = "294";
      iframe.src = "https://www.youtube.com/embed/" + key + "?&theme=dark&color=white&rel=0";
      iframe.style.border = "none";
      iframe.allowFullscreen = true;
      iframe.title = name;
      iframe.classList.add("img-cover");
      iframe.loading = "lazy";

      videoCard.appendChild(iframe);
      sliderInner.appendChild(videoCard);
    }
    
    pageContent.appendChild(movieDetail);

    // Recupera e aggiunge i film suggeriti dall'API di TMDB
    fetchDataFromServer("movie/recommendations?mid="+encodeURIComponent(movieId), addSuggestedMovies);

  }
);

// Funzione per aggiungere i film suggeriti alla pagina
const addSuggestedMovies = function ({ results: movieList }, title) {

  const movieListElem = document.createElement("section");
  movieListElem.classList.add("movie-list");
  movieListElem.ariaLabel = "Potrebbe piacerti";

  const titleWrapper = document.createElement("div");
  titleWrapper.classList.add("title-wrapper");

  const titleLarge = document.createElement("h3");
  titleLarge.classList.add("title-large");
  titleLarge.textContent = "Potrebbe piacerti";

  titleWrapper.appendChild(titleLarge);

  const sliderList = document.createElement("div");
  sliderList.classList.add("slider-list");

  const sliderInner = document.createElement("div");
  sliderInner.classList.add("slider-inner");

  sliderList.appendChild(sliderInner);

  movieListElem.appendChild(titleWrapper);
  movieListElem.appendChild(sliderList);

  // Crea e aggiunge una scheda per ogni film suggeritoDeadpool 533535
  for ( const movie of movieList ) {
    const movieCard = createMovieCard(movie);
    sliderInner.appendChild(movieCard);
  }

  // Aggiunge la sezione dei film suggeriti al contenuto della pagina
  pageContent.appendChild(movieListElem);
};

// Richiama la funzione di ricerca
searchMovie();
