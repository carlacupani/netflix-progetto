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

  /**
   function addModalHeader(query) {
    const label = document.createElement("p");
    label.classList.add("label");
    label.textContent = "Risultati per ...";

    const heading = document.createElement("h1");
    heading.classList.add("heading");
    heading.textContent = query;

    searchResultModal.appendChild(label);
    searchResultModal.appendChild(heading);
  }
  
   */

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
  async function fetchMovies(query) {
    try {
      const response = await fetch(`/search/movie?q=${encodeURIComponent(query)}`);
      if (!response.ok) {
        throw new Error("Errore nella richiesta al server");
      }
      const data = await response.json();
      return data.results;
    } catch (error) {
      console.error("Errore durante il fetch dei dati:", error);
      return [];
    }
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

    searchTimeout = setTimeout(async () => {
      const movieList = await fetchMovies(query);
      searchWrapper.classList.remove("searching");
      toggleSearchModal(true);

      clearModalContent();
      //addModalHeader(query);
      displayMovieResults(movieList);
    }, 500);
  }

  // --- Event listener ---
  searchBtn.addEventListener("click", openSearch); // Apre la barra di ricerca
  closeBtn.addEventListener("click", closeSearch); // Chiude la barra di ricerca

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
      closeSearch(); // Chiude la barra con il tasto ESC
    }
  });

  searchField.addEventListener("input", handleSearchInput); // Gestisce l'input
}
