"use strict";

import { createMovieCard } from "./movie-card.js";

// Funzione principale per la gestione della barra di ricerca
export function searchMovie() {
  // Elementi del DOM
  const searchWrapper = document.querySelector(".search-wrapper");
  const searchField = document.querySelector(".search-field");
  const searchBtn = document.querySelector(".search-btn");
  const closeBtn = document.querySelector(".close-btn");

  // Modal dei risultati
  const searchResultModal = document.createElement("div");
  searchResultModal.classList.add("search-modal");
  document.querySelector("main").appendChild(searchResultModal);

  let searchTimeout; // Timeout per la ricerca

  // --- Funzioni per l'apertura e la chiusura della barra di ricerca ---
  function openSearch() {
    searchWrapper.classList.add("active");
    searchField.focus();
  }

  function closeSearch() {
    searchWrapper.classList.remove("active");
    searchField.value = ""; // Pulisce il campo di ricerca
    clearModalContent(); // Pulisce i risultati
    toggleSearchModal(false); // Nasconde il modal
  }

  // --- Gestione del modal dei risultati ---
  function toggleSearchModal(show) {
    if (show) {
      searchResultModal.classList.add("active");
    } else {
      searchResultModal.classList.remove("active");
    }
  }

  function clearModalContent() {
    searchResultModal.innerHTML = "";
  }


  function displayMovieResults(movieList) {
    const movieListContainer = document.createElement("div");
    movieListContainer.classList.add("movie-list");

    const gridList = document.createElement("div");
    gridList.classList.add("grid-list");
    movieListContainer.appendChild(gridList);

    movieList.forEach((movie) => {
      const movieCard = createMovieCard(movie);
      gridList.appendChild(movieCard);
    });

    searchResultModal.appendChild(movieListContainer);
  }


// --- Funzioni per la ricerca ---
function fetchMovies(query) {
  query
  return fetch(`/search/movie?q=${encodeURIComponent(query)}`)
    .then((response) => {
      if (!response.ok) {
        console.log('Errore nella risposta della rete:', response.status);
        return [];
      }
      return response.json();
    })
    .then((data) => {
      if (data && data.results) {
        return data.results;
      } else {
        console.log('Nessun risultato trovato');
        return [];
      }
    })
    .catch((error) => {
      console.log('Errore durante il fetch dei dati:', error);
      return [];
    });
}


function handleSearchInput() {
  const query = searchField.value.trim();

  if (!query) {
    toggleSearchModal(false);
    searchWrapper.classList.remove("searching");
    clearTimeout(searchTimeout);
    return;
  }

  searchWrapper.classList.add("searching");
  clearTimeout(searchTimeout);

  searchTimeout = setTimeout(() => {
    fetchMovies(query)
      .then((movieList) => {
        searchWrapper.classList.remove("searching");
        toggleSearchModal(true);

        clearModalContent();
        // addModalHeader(query);
        displayMovieResults(movieList);
      })
      .catch((error) => {
        console.error("Errore durante la ricerca dei film:", error);
        searchWrapper.classList.remove("searching");
        toggleSearchModal(false);
      });
  }, 300);
}

  // --- Event listener ---
  searchBtn.addEventListener("click", openSearch); // Apre la barra di ricerca
  closeBtn.addEventListener("click", closeSearch); // Chiude la barra di ricerca

  searchField.addEventListener("input", handleSearchInput); // Gestisce l'input
}
