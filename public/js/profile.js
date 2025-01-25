"use strict";

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
          if (!response.ok) {
              console.log("response no ok");
          }
          return response.json();
      })
      .then(quote => {
        const container = document.querySelector('.quote-wrapper');

        container.innerHTML = '';
        
        const quoteBox = document.createElement('div');
        quoteBox.className = 'quote-box';
        
        // Creazione del blockquote
        const blockquote = document.createElement('blockquote');
        blockquote.className = 'blockquote';
        
        // Aggiungi un contenitore per immagine e testo
        const contentWrapper = document.createElement('div');
        contentWrapper.className = 'content-wrapper';
        
        // Immagine del brush
        const brushImage = document.createElement('img');
        brushImage.src = '../images/brush.png';
        brushImage.className = 'brush-icon';
        
        // Testo della frase
        const quoteText = document.createElement('span');
        quoteText.textContent = quote.sentence;
        quoteText.className = 'quote-text';
        
        // Aggiungi immagine e testo al contenitore
        contentWrapper.appendChild(brushImage);
        contentWrapper.appendChild(quoteText);
        blockquote.appendChild(contentWrapper);
        
        // Footer per autore e casa
        const author = document.createElement('div');
        author.className = 'author';
        author.textContent = "- " + quote.character.name + ", " + quote.character.house.name;
        
        blockquote.appendChild(author);
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
