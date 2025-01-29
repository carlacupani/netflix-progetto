"use strict";

const imageBaseURL = 'https://image.tmdb.org/t/p/';

export function createMovieCard(movie) {
  
  const posterPath = movie.poster_path;
  const title = movie.title;
  const movieId = movie.id;

  const card = document.createElement("div");
  card.classList.add("movie-card");

  const figure = document.createElement("div");
  figure.classList.add("poster-box", "card-banner");

  const img = document.createElement("img");
  img.src = imageBaseURL + "w342" + posterPath;
  img.classList.add("img-cover");
  img.loading = "lazy";

  figure.appendChild(img);
  card.appendChild(figure);

  const anchor = document.createElement("a");
  anchor.href = "movie/details" + movieId;
  anchor.classList.add("card-btn");
  anchor.title = title;

  card.appendChild(anchor);

  return card;
}


