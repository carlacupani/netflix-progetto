"use strict";
const imageBaseURL = 'https://image.tmdb.org/t/p/';

import { createMovieCard } from "./movie-card.js";
import { searchMovie } from "./search-movie.js";

const pageContent = document.querySelector("[page-content]");

fetch("/movie/upcoming")
  .then((res) => res.json())
  .then((data) => createBannerSection(data))
  .catch((error) => console.error("Error fetching banner", error));


  function createBannerSection({ results: movies }) {
    const banner = document.querySelector('.banner');
  
    const movie = movies[0]; 

    const bannerContents = document.createElement('div');
    bannerContents.classList.add('banner_contents');
    
    const bannerImg = document.createElement('img');
    bannerImg.src = 'https://image.tmdb.org/t/p/w1280' + movie.backdrop_path;
    bannerImg.classList.add('banner-img');

    const titleText = document.createElement('div');
    titleText.classList.add('banner-title');
    titleText.textContent = movie.title;
    
    const seasonText = document.createElement('div');
    seasonText.classList.add('banner-season');
    seasonText.textContent = `Stagione 2 in arrivo il 30 gennaio`;
  
    const description = document.createElement('div');
    description.classList.add('banner-description');
    description.textContent = movie.overview || "Descrizione non disponibile.";
    
    const buttons = document.createElement('div');
    buttons.classList.add('banner-buttons');
    
    const playButton = document.createElement('button');
    playButton.classList.add('banner-btn1', 'play');
    //playButton.innerHTML = `<img class="icon" src="../../images/HomePage/Header/play.svg">Assistir`;
    
    const infoButton = document.createElement('button');
    infoButton.classList.add('banner-btn2', 'info');
    //infoButton.innerHTML = `<img class="icon" src="../../images/HomePage/Header/info.svg">Informações`;
  
    buttons.appendChild(playButton);
    buttons.appendChild(infoButton);

    bannerContents.appendChild(bannerImg);
    bannerContents.appendChild(titleText);
    bannerContents.appendChild(seasonText);
    bannerContents.appendChild(description);
    bannerContents.appendChild(buttons);
    
    banner.appendChild(bannerContents);
}

const genreList = {
  asString(genreIdList) {
    return genreIdList.map((id) => this[id]).filter(Boolean).join(", ");
  },
};

fetch("/genre/movie/list")
  .then((res) => res.json())
  .then(({ genres }) => {
    genres.forEach(({ id, name }) => (genreList[id] = name));
    loadHomeSections();
  })
  .catch((error) => console.error("Error fetching genres:", error));

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
