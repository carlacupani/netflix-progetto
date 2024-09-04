"use strict";

import { fetchDataFromServer } from "./api.js";
import { createSerieCard } from "./serie-card.js";

export function searchSerie() {
  const searchWrapper = document.querySelector("[search-wrapper]");
  const searchField = document.querySelector("[search-field]");

  const searchResultModal = document.createElement("div");
  searchResultModal.classList.add("search-modal");
  document.querySelector("main").appendChild(searchResultModal);

  let searchTimeout;

  searchField.addEventListener("input", function () {
    if (!searchField.value.trim()) {
      searchResultModal.classList.remove("active");
      searchWrapper.classList.remove("searching");
      clearTimeout(searchTimeout);
      return;
    }

    searchWrapper.classList.add("searching");
    clearTimeout(searchTimeout);

    searchTimeout = setTimeout(function () {
      fetchDataFromServer(
        "/search/serietv?q=" + encodeURIComponent(searchField.value),
        function ({ results: serieList }) {
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

          const serieListContainer = document.createElement("div");
          serieListContainer.classList.add("serie-list");

          const gridList = document.createElement("div");
          gridList.classList.add("grid-list");
          serieListContainer.appendChild(gridList);

          searchResultModal.appendChild(serieListContainer);

          for (const serie of serieList) {
            const serieCard = createSerieCard(serie);
            gridList.appendChild(serieCard);
          }
        }
      );
    }, 500); // Ritarda la ricerca di 0.5secondi
  });
}
