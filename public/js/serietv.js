"use strict";

const imageBaseURL = 'https://image.tmdb.org/t/p/';

import { createSerieCard } from "./serie-card.js";
import { searchSerie } from "./search-serie.js";

const sectionContainer = document.querySelector(".section-container");


fetch("/serietv/popular")
  .then((res) => res.json())
  .then((data) => createBannerSection(data))
  .catch((error) => console.error("Error fetching banner", error));

function createBannerSection({ results: serieList }) {
    const banner = document.querySelector('.banner');

    const serie = serieList[0];
    const serietvId = serie.id;
  
    banner.style.backgroundImage = "url('" + imageBaseURL + "w1280"+ serie.backdrop_path + "')";
  
    const bannerContents = document.createElement('div');
    bannerContents.classList.add('banner-contents');
  
    const titleText = document.createElement('div');
    titleText.classList.add('banner-title');
    titleText.textContent = serie.name;
  
    const description = document.createElement('div');
    description.classList.add('banner-description');
    description.textContent = serie.overview || "Descrizione non disponibile.";
  
    const buttons = document.createElement('div');
    buttons.classList.add('banner-buttons');
  
    const playButton = document.createElement('button');
    playButton.classList.add('banner-btn1');
  
    const playIcon = document.createElement('img');
    playIcon.classList.add('icon');
    playIcon.src= '../images/play-button.png';
    const playText = document.createTextNode('Riproduci');
  
    const infoButton = document.createElement('button');
    infoButton.classList.add('banner-btn2');
  
    const infoIcon = document.createElement('img');
    infoIcon.classList.add('icon');
    infoIcon.src = '/images/menu.png';
    const infoText = document.createTextNode('Altre info');
  
    infoButton.addEventListener('click', () => {
      window.location.href = "serietv/details" + serietvId;
    });
  
    buttons.appendChild(playButton);
    playButton.appendChild(playIcon);
    playButton.appendChild(playText);
  
    buttons.appendChild(infoButton);
    infoButton.appendChild(infoIcon);
    infoButton.appendChild(infoText);
  
    bannerContents.appendChild(titleText);
    bannerContents.appendChild(description);
    bannerContents.appendChild(buttons);
  
    banner.appendChild(bannerContents);
  }

  const genreList = {
    asString(genreIdList) {
      return genreIdList.map((id) => this[id]).filter(Boolean).join(", ");
    },
  };

fetch("/genre/serietv/list")
.then((res) => res.json())
.then(({ genres }) => {
  genres.forEach(({ id, name }) => (genreList[id] = name));
  loadHomeSections();
})
.catch((error) => console.error("Error fetching genres:", error));

function loadHomeSections() {
  const sections = [
    { url: "/serietv/on_the_air", title: "In uscita" },
    { url: "/trending/tv/week", title: "In tendenza questa settimana" },
    { url: "/serietv/top_rated", title: "Più votati" },
    { url: "/serietv/popular", title: "Più popolari tra i giovani" },
  ];

  sections.forEach(({ url, title }) => {
    fetch(url)
      .then((res) => res.json())
      .then((data) => createSerieSection(data, title))
      .catch((error) => console.error('Error fetching' + title + ':', error));
  });
}

function createSerieSection({ results: serieList }, title) {
  const section = document.createElement("section");
  section.classList.add("serie-list");

  const titleWrapper = document.createElement("div");
  titleWrapper.classList.add("title-wrapper");

  const titleElement = document.createElement("h3");
  titleElement.classList.add("title-large");
  titleElement.textContent = title;

  titleWrapper.appendChild(titleElement);

  const sliderList = document.createElement("div");
  sliderList.classList.add("slider-list");

  const sliderInner = document.createElement("div");
  sliderInner.classList.add("slider-inner");

  serieList.forEach((serie) => {
    const serieCard = createSerieCard(serie);
    sliderInner.appendChild(serieCard);
  });

  sliderList.appendChild(sliderInner);

  section.appendChild(titleWrapper);
  section.appendChild(sliderList);

  sectionContainer.appendChild(section);
}

searchSerie();
