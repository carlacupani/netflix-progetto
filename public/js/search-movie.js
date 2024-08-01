"use strict";

// Importa le funzioni necessarie da altri moduli
import { fetchDataFromServer } from "./api.js";
import { createMovieCard } from "./movie-card.js";

export function searchMovie() {
  // Seleziona gli elementi della pagina necessari per la ricerca
  const searchWrapper = document.querySelector("[search-wrapper]");
  const searchField = document.querySelector("[search-field]");

  // Crea e aggiunge il contenitore per i risultati della ricerca
  const searchResultModal = document.createElement("div");
  searchResultModal.classList.add("search-modal");
  document.querySelector("main").appendChild(searchResultModal);

  let searchTimeout;

  // Aggiunge un ascoltatore per l'evento di input del campo di ricerca
  searchField.addEventListener("input", function () {
    // Se il campo di ricerca è vuoto, nasconde i risultati e interrompe la ricerca
    if (!searchField.value.trim()) {
      searchResultModal.classList.remove("active");
      searchWrapper.classList.remove("searching");
      clearTimeout(searchTimeout);
      return;
    }

    // Aggiunge una classe per indicare che è in corso una ricerca
    searchWrapper.classList.add("searching");
    clearTimeout(searchTimeout);

    // Ritarda l'esecuzione della ricerca per evitare chiamate eccessive al server
    searchTimeout = setTimeout(function () {
      // Effettua una richiesta al server per ottenere i dati dei film
      fetchDataFromServer(
        "/search/movie?q=" + encodeURIComponent(searchField.value),
        function ({ results: movieList }) {
          // Rimuove la classe di ricerca e mostra i risultati
          searchWrapper.classList.remove("searching");
          searchResultModal.classList.add("active");

          // Pulisce i risultati precedenti se presenti
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

          // Crea un contenitore per la lista dei film
          const movieListContainer = document.createElement("div");
          movieListContainer.classList.add("movie-list");

          // Crea un contenitore per la visualizzazione a griglia dei film
          const gridList = document.createElement("div");
          gridList.classList.add("grid-list");
          movieListContainer.appendChild(gridList);

          // Aggiunge il contenitore della lista dei film al modale dei risultati
          searchResultModal.appendChild(movieListContainer);

          // Crea e aggiunge una scheda per ogni film trovato
          for (const movie of movieList) {
            const movieCard = createMovieCard(movie);
            gridList.appendChild(movieCard);
          }
        }
      );
    }, 500); // Ritarda la ricerca di 500 millisecondi
  });
}
