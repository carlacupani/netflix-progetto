"use strict";

import { fetchDataFromServer } from "./api.js";
import { createMovieCard } from "./movie-card.js";

export function search() {
  const searchWrapper = document.querySelector("[search-wrapper]");
  const searchField = document.querySelector("[search-field]");

  // Crea e aggiunge il contenitore per i risultati della ricerca
  const searchResultModal = document.createElement("div");
  searchResultModal.classList.add("search-modal");
  document.querySelector("main").appendChild(searchResultModal);

  let searchTimeout;

  searchField.addEventListener("input", function () {
    if (!searchField.value.trim()) {
      // Nasconde i risultati se il campo di ricerca è vuoto
      searchResultModal.classList.remove("active");
      searchWrapper.classList.remove("searching");
      clearTimeout(searchTimeout);
      return;
    }

    searchWrapper.classList.add("searching");
    clearTimeout(searchTimeout);

    // Ritarda la ricerca per evitare chiamate eccessive
    searchTimeout = setTimeout(function () {
      fetchDataFromServer(
        "get_search_movie.php?q=" + encodeURIComponent(searchField.value),
        function ({ results: movieList }) {
          searchWrapper.classList.remove("searching");
          searchResultModal.classList.add("active");

          // Rimuove i risultati precedenti
          while (searchResultModal.firstChild) {
            searchResultModal.removeChild(searchResultModal.firstChild);
          }

          // Aggiunge un'etichetta e un'intestazione per i risultati della ricerca
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

          // Crea e aggiunge una scheda per ogni film trovato
          for (const movie of movieList) {
            const movieCard = createMovieCard(movie);
            gridList.appendChild(movieCard);
          }
        }
      );
    }, 500);
  });
}
