"use strict";

const imageBaseURL = 'https://image.tmdb.org/t/p/';

export function createMovieCard(movie) {
  
  const posterPath = movie.poster_path;
  const title = movie.title;
  const id = movie.id;

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
  anchor.href = "details_movie";
  anchor.classList.add("card-btn");
  anchor.title = title;
  anchor.addEventListener("click", () => {
    window.localStorage.setItem("movieId", String(id));
  });

  card.appendChild(anchor);

  return card;
}


