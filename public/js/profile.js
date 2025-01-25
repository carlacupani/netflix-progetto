"use strict";

const pageContent = document.querySelector("[page-content]");

function fetchQuote() {
  fetch('https://api.gameofthronesquotes.xyz/v1/random')
    .then((res) => res.json())
    .then(quote => {
      const container = document.querySelector('.quote-wrapper');

      const quoteBox = document.createElement('div');
      quoteBox.className = 'quote-box';
        
      const blockquote = document.createElement('blockquote');
      blockquote.className = 'blockquote';
        
      const contentWrapper = document.createElement('div');
      contentWrapper.className = 'content-wrapper';
      
      const brushImage = document.createElement('img');
      brushImage.src = '../images/brush.png';
      brushImage.className = 'brush-icon';
        
      const quoteText = document.createElement('span');
      quoteText.textContent = quote.sentence;
      quoteText.className = 'quote-text';
        
      contentWrapper.appendChild(brushImage);
      contentWrapper.appendChild(quoteText);
      blockquote.appendChild(contentWrapper);
        
      const author = document.createElement('div');
      author.className = 'author';
      author.textContent = "- " + quote.character.name + ", " + quote.character.house.name;
        
      blockquote.appendChild(author);
      quoteBox.appendChild(blockquote);
      container.appendChild(quoteBox);

    })
    .catch((error) => console.error("Error fetching banner", error));
}

fetchQuote();
