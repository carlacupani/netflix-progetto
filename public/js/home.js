"use strict";

/* Import delle funzioni e costanti */
import { createMovieCard } from "./movie-card.js";
import { searchMovie } from "./search-movie.js";

const pageContent = document.querySelector("[page-content]");

const genreList = {
  // Converte un array di ID genere in una stringa di generi separati da virgola
  asString(genreIdList) {
    return genreIdList.map((id) => this[id]).filter(Boolean).join(", ");
  },
};

// Fetch della lista generi e caricamento delle sezioni
fetch("/genre/movie/list")
  .then((res) => res.json())
  .then(({ genres }) => {
    genres.forEach(({ id, name }) => (genreList[id] = name));
    loadHomeSections();
  })
  .catch((error) => console.error("Error fetching genres:", error));

// Carica le sezioni della homepage con i film
function loadHomeSections() {
  const sections = [
    { url: "/movie/upcoming", title: "In uscita" },
    { url: "/trending/movie/week", title: "In tendenza questa settimana" },
    { url: "/movie/top_rated", title: "Più votati" },
    { url: "/movie/popular", title: "Più popolari tra i giovani" },
  ];

  sections.forEach(({ url, title }) => {
    fetch(url)
      .then((res) => res.json())
      .then((data) => createMovieSection(data, title))
      .catch((error) => console.error(`Error fetching ${title}:`, error));
  });
}

// Crea una sezione con i film
function createMovieSection({ results: movies }, title) {
  const section = document.createElement("section");
  section.classList.add("movie-list");
  
  section.innerHTML = `
    <div class="title-wrapper">
      <h3 class="title-large">${title}</h3>
    </div>
    <div class="slider-list">
      <div class="slider-inner">
        ${movies.map((movie) => createMovieCard(movie).outerHTML).join("")}
      </div>
    </div>
  `;

  pageContent.appendChild(section);
}

searchMovie();
