"use strict";

const imageBaseURL = 'https://image.tmdb.org/t/p/';

export function createMovieCard(movie) {
  const { backdrop_path,
    title,
    id
  } = movie;

  const card = document.createElement("div");
  card.classList.add("movie-card");

  const figure = document.createElement("figure");
  figure.classList.add("poster-box", "card-banner");

  const img = document.createElement("img");
  img.src = imageBaseURL + "w342" + backdrop_path;
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


