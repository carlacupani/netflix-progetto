"use strict";

import { fetchDataFromServer } from "./api.js";
import {createMovieCard} from "./movie-card.js"
import {createSerieCard} from "./serie-card.js"

const pageContent = document.querySelector("[page-content]");

const createFavoriteMovieList = function (movies) {
  // Controllo se la lista dei film è vuota
  if (movies.length === 0) {
    const noFavoritesMessage = document.createElement("p");
    noFavoritesMessage.textContent = "Non hai aggiunto preferiti"; // Mando questo messaggio solo se è vuota
    noFavoritesMessage.classList.add("title-large");
    pageContent.appendChild(noFavoritesMessage);
    return;
  }

  const movieListElem = document.createElement("section");
  movieListElem.classList.add("movie-list");
  movieListElem.ariaLabel = "La mia lista";

  const titleWrapper = document.createElement("div");
  titleWrapper.classList.add("title-wrapper");

  const h3 = document.createElement("h3");
  h3.classList.add("title-large");
  h3.textContent = "La mia lista"; // Titolo della sezione
  titleWrapper.appendChild(h3);

  movieListElem.appendChild(titleWrapper);

  const sliderList = document.createElement("div");
  sliderList.classList.add("slider-list");

  const sliderInner = document.createElement("div");
  sliderInner.classList.add("slider-inner");
  sliderList.appendChild(sliderInner);

  movieListElem.appendChild(sliderList);

  // Creazione delle card dei film per la sezione dei film preferiti
  for (const movie of movies) {
    // Verifica e aggiungi i campi mancanti con valori di default
    movie.vote_average = movie.vote_average !== undefined ? parseFloat(movie.vote_average) : 0;
    movie.release_date = movie.release_date || "N/A";
    
    if(movie.isSerie == 1){

      const serieCard = createSerieCard(movie);
      sliderInner.appendChild(serieCard);

    }else{

      const movieCard = createMovieCard(movie);
      sliderInner.appendChild(movieCard);
      
    }

  }

  pageContent.appendChild(movieListElem);
};

// Fetch dei film preferiti dal server
fetch("favorite_movie")
  .then((response) => response.json())
  .then((data) => {
    console.log(data.films);
    createFavoriteMovieList(data.films);
})
  .catch((error) => console.error("Error:", error)); 



// Funzione per ottenere e visualizzare una nuova citazione
function fetchQuote() {
  fetch('https://api.gameofthronesquotes.xyz/v1/random')
      .then(response => {
          // Verifica se la risposta è OK
          if (!response.ok) {
              throw new Error('Network response was not ok');
          }
          return response.json();
      })
      .then(quote => {
          const container = document.querySelector('.quote-wrapper');

          // svuota
          container.innerHTML = '';

          const quoteBox = document.createElement('div');
          quoteBox.id = 'quote-box';
          quoteBox.className = 'quote-box';

          const blockquote = document.createElement('blockquote');
          blockquote.className = 'blockquote';
          blockquote.id = 'quote';
          blockquote.textContent = quote.sentence;

          const footer = document.createElement('footer');
          footer.id = 'autore';
          footer.textContent = "- " + quote.character.name + ", " + quote.character.house.name;

          blockquote.appendChild(footer);

          quoteBox.appendChild(blockquote);

          container.appendChild(quoteBox);
      })
      .catch(error => {
          console.error('Errore durante il fetch:', error);
          const container = document.querySelector('.quote-wrapper');
          container.innerHTML = '<p>Errore nel recuperare la citazione. Riprova più tardi.</p>';
      });
}

window.onload = fetchQuote;
