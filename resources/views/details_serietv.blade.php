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
        <li><a href="{{ URL::to("mialista") }}">La mia lista</a></li>
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
    <div hidden id="userId" data-user-id="{{ Session::get('user_id') }}"></div>
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