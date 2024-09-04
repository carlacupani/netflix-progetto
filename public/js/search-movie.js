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

  searchField.addEventListener("input", function () 
   {
    if (!searchField.value.trim()) {
      searchResultModal.classList.remove("active");
      searchWrapper.classList.remove("searching");
      clearTimeout(searchTimeout);
      return;
    }

    searchWrapper.classList.add("searching");
    clearTimeout(searchTimeout);

    searchTimeout = setTimeout(function () 
    {
      fetchDataFromServer(
        "/search/movie?q=" + encodeURIComponent(searchField.value),
        function ({ results: movieList }) {
          searchWrapper.classList.remove("searching");
          searchResultModal.classList.add("active");

          while (searchResultModal.firstChild) {
            searchResultModal.removeChild(searchResultModal.firstChild);
          }

          const label = document.createElement("p");
          label.classList.add("label");
          label.textContent = "Risultati per ...";
          searchResultModal.appendChild(label);

          const heading = document.createElement("h1");
          heading.classList.add("heading");
          heading.textContent = searchField.value;
          searchResultModal.appendChild(heading);

          const movieListContainer = document.createElement("div");
          movieListContainer.classList.add("movie-list");

          const gridList = document.createElement("div");
          gridList.classList.add("grid-list");
          movieListContainer.appendChild(gridList);

          searchResultModal.appendChild(movieListContainer);

          for (const movie of movieList) {
            const movieCard = createMovieCard(movie);
            gridList.appendChild(movieCard);
          }
        }
      );
    }, 500);

  });
}
