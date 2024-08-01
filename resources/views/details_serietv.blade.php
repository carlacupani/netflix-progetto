<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- TOKEN -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!--google font link-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap" rel="stylesheet">
  <!--css link-->
  <link rel="stylesheet" href='{{ URL::to("css/serietv.css") }}'>
  <!--custom js link-->
  <script src='{{ URL::to("js/global.js") }}' defer></script>
  <script src='{{ URL::to("js/detail_serietv.js") }}' type="module"></script>
</head>

<body>
  <!--HEADER-->
  <header class="header" id="home">
    <div class="navbar-left">
      <a href="{{ URL::to("home") }}" class="logo">
        <img src='{{ URL::to("images/logo.png") }}' width="140" height="32">
      </a>
      <ul class="navbar-links">
        <li><a href="{{ URL::to("home") }}">Film</a></li>
        <li><a href="{{ URL::to("serietv") }}">Serie Tv</a></li>
        <li><a href="{{ URL::to("profile") }}">La mia lista</a></li>
      </ul>
    </div>

    <div class="navbar-right">
      <div class="search-box" search-box>
        <div class="search-wrapper" search-wrapper>
          <input type="text" name="search" aria-label="search movies" placeholder="Search any movies..." class="search-field" autocomplete="off" search-field>
          <img src="./images/search.png" width="24" height="24" alt="search" class="leading-icon">
        </div>
        <button class="search-btn" search-toggler>
          <img src="./images/close.png" width="24" height="24" alt="close search box">
        </button>
      </div>
      <button class="search-btn" search-toggler menu-close>
        <img src="./images/search.png" width="24" height="24" alt="open search box">
      </button>
      <button class="menu-btn" menu-btn menu-toggler>
        <img src="./images/menu.png" width="24" height="24" alt="open menu" class="menu">
        <img src="./images/menu-close.png" width="24" height="24" alt="close menu" class="close">
      </button>
      <!-- ACCOUNT -->
      <div class="userInfo">
        <a href="{{ URL::to("profile") }}">
          <div class="avatar">
          </div>
        </a>
      </div>
    </div>
  </header>

  <main>
    <div class="overlay" overlay menu-toggler></div>
    <article class="container" page-content></article>
  </main>

  <!--FOOTER-->
  <footer>
    <h2>Domande? Chiama 800-130-364</h2>
    <div class="row">
      <div class="col">
        <a href="#">Autodescrizione</a>
        <a href="#">Rapporti con gli investitori</a>
        <a href="#">Note legali</a>
        <a href="#">Preferenze per la pubblicità</a>
      </div>
      <div class="col">
        <a href="#">Centro assistenza</a>
        <a href="#">Opportunità di lavoro</a>
        <a href="#">Preferenze per i cookie</a>
        <a href="#"> </a>
      </div>
      <div class="col">
        <a href="#">Carte regalo</a>
        <a href="#">Condizioni di utilizzo</a>
        <a href="#">Informazioni sull'azienda</a>
        <a href="#"> </a>
      </div>
      <div class="col">
        <a href="#">Media Center</a>
        <a href="#">Privacy</a>
        <a href="#">Contattaci</a>
        <a href="#"> </a>
      </div>
    </div>
    <p class="copyright-txt">Netflix Italia</p>
  </footer>
</body>

</html>