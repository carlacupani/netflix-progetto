"use strict";

// Importa le funzioni necessarie da altri moduli
import { createMovieCard } from "./movie-card.js";

export function searchMovie() {
  const searchWrapper = document.querySelector("[search-wrapper]");
  const searchField = document.querySelector("[search-field]");

  const searchResultModal = document.createElement("div");
  searchResultModal.classList.add("search-modal");
  document.querySelector("main").appendChild(searchResultModal);

  let searchTimeout;

  function toggleSearchModal(show) {
    if (show) {
      searchResultModal.classList.add("active");
    } else {
      searchResultModal.classList.remove("active");
    }
  }

  function clearModalContent() {
    searchResultModal.innerHTML = '';
  }

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

  function displayMovieResults(movieList) {
    const movieListContainer = document.createElement("div");
    movieListContainer.classList.add("movie-list");
  
    const gridList = document.createElement("div");
    gridList.classList.add("grid-list");
    movieListContainer.appendChild(gridList);
  
    movieList.forEach(movie => {
      const movieCard = createMovieCard(movie);
      gridList.appendChild(movieCard);
    });
  
    searchResultModal.appendChild(movieListContainer);
  }

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

  async function handleSearchInput() {
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
      addModalHeader(query);
      displayMovieResults(movieList);
    }, 500);
  }

  searchField.addEventListener("input", handleSearchInput);
}
