<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- TOKEN -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Benvenuto su Netflix</title>
  <link rel="icon" href="images/netflix-logo-icon.ico" type="image/x-icon">
  <!-- CSS LINK -->
  <link rel="stylesheet" href='{{ URL::to("css/home.css") }}'>
  <!-- JS LINK -->
  <script src='{{ URL::to("js/global.js") }}' defer="true"></script>
  <script src='{{ URL::to("js/home.js") }}' type="module"></script>
</head>


<body>
  <!--NAVBAR-->
  <header class="header" id="home">
    <div class="navbar-left">
      <a href="{{ URL::to("home") }}" class="logo">
        <img src='{{ URL::to("images/logo.png") }}' width="140" height="32">
      </a>
      <ul class="navbar-links">
        <li><a href="{{ URL::to("home") }}">Home</a></li>
        <li><a href="#">Serie Tv</a></li>
        <li><a href="{{ URL::to("movie") }}">Film</a></li>
        <li><a href="#">Nuovi e popolari</a></li>
        <li><a href="{{ URL::to("mialista") }}">La mia lista</a></li>
        <li><a href="#">Sfoglia per lingua</a></li>
      </ul>
    </div>
    <div class="navbar-right">
      <div class="nav-element">
        <div class="search-box">
          <button class="search-btn">
            <img src="{{ URL::to("images/search.png") }}" alt="">
          </button>
          <div class="search-wrapper">
            <input type="text" name="search" aria-label="search movies" placeholder="Titoli, persone, generi" class="search-field" autocomplete="off"/>
          </div>
          <button class="close-btn">
            <img src="{{ URL::to("images/close-button.png") }}" alt="">
          </button>
        </div>
      </div>
      <div class="nav-element">
        <button class="notification-btn">
          <img src="{{ URL::to('images/notification-bell.png') }}">
        </button>
      </div>
      <!-- ACCOUNT -->
      <div class="nav-element">
        <div class="userInfo">
          <a href="{{ URL::to("profile") }}">
            <div class="avatar">
            </div>
          </a>
        </div>
      </div>
    </div>
  </header>
  <main>
    <!--HEADER-->
    <div class="banner"></div>
    <!--FILM-->
    <section class="section-container"></section>
  </main>
  <!--FOOTER-->
  <footer>
      <h2>Domande? Chiama 800-130-364</h2>
      <div class="row">
            <div class="col">
                <a href="#">Autodescrizione</a>
                <a href="https://ir.netflix.net/ir-overview/profile/default.aspx">Rapporti con gli investitori</a>
                <a href="https://help.netflix.com/legal/notices">Note legali</a>
                <a href="https://help.netflix.com/it/node/100637">Preferenze per la pubblicità</a>
            </div>
            <div class="col">
                <a href="https://help.netflix.com/it">Centro assistenza</a>
                <a href="https://jobs.netflix.com/">Opportunità di lavoro</a>
                <a href="#">Preferenze per i cookie</a>
                <a href="#"> </a>
            </div>
            <div class="col">
                <a href="https://www.netflix.com/it/redeem">Carte regalo</a>
                <a href="https://help.netflix.com/legal/termsofuse">Condizioni di utilizzo</a>
                <a href="https://help.netflix.com/it/node/134094">Informazioni sull'azienda</a>
                <a href="#"> </a>
            </div>
            <div class="col">
                <a href="https://media.netflix.com/it/">Media Center</a>
                <a href="https://help.netflix.com/legal/privacy">Privacy</a>
                <a href="https://help.netflix.com/it/contactus">Contattaci</a>
                <a href="#"> </a>
            </div>
        </div>
        <p class="copyright-txt">Netflix Italia</p>
    </footer>
</body>
</html>