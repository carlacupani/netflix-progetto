"use strict";

// Importa le funzioni necessarie da altri moduli
import { fetchDataFromServer } from "./api.js";
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
      fetchDataFromServer(`/search/movie?q=${encodeURIComponent(query)}`, ({ results: movieList }) => {
        searchWrapper.classList.remove("searching");
        toggleSearchModal(true);
  
        clearModalContent();
        addModalHeader(query);
        displayMovieResults(movieList);
      });
    }, 500);
  }
  
  searchField.addEventListener("input", handleSearchInput);

}
