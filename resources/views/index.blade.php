<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- primary meta tags -->
    <title>Netflix</title>
    <meta name="title" content="Netflix">
    <!-- google font link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap" rel="stylesheet">
    <!-- css link -->
    <link rel="stylesheet" href='{{ URL::to("css/index.css") }}'>
    <!-- js link -->
    <script src='{{ URL::to("js/index.js") }}' defer></script>
</head>

<body>
    <header>
        <!-- NAVBAR -->
        <nav>
            <a href="{{ URL::to('index') }}">
                <img id="logo1" src="{{ URL::to('images/logo.png') }}" class="logo1">
            </a>
            <div class="navbar-right">
                <div class="navbar-language-select">
                    <select class="language-select">
                        <option value="it">Italiano</option>
                        <option value="en">Inglese</option>
                    </select>
                </div>
                <button class="login-btn" onclick="window.location.href='login'">Accedi</button>
            </div>
        </nav>
        <!-- BANNER -->
        <div class="header-content">
            <h1>Film, serie TV e tanto altro, senza limiti</h1>
            <h3>A partire da 6,99 €. Disdici quando vuoi.</h3>
            <p class="email-form-title">Vuoi guardare Netflix? Inserisci l'indirizzo email per abbonarti o riattivare il tuo abbonamento.</p>
            <div class="email-signup">
                <div class="form-control">
                    <input type="email" id="signup-email-1" name="email" required>
                    <label for="email_phone">Indirizzo Email</label>
                </div>
                <a>
                    <button disabled type="submit" id="signup-btn-1">Inizia ></button>
                </a>
            </div>
        </div>
    </header>
    <!-- announcement -->
    <section class="announcement">
        <div class="section1">
            <img src="{{ URL::to('images/crown.png') }}" alt="">
            <div class="announcement-bar">
                <span>
                    <b>Tutto ciò che ami di Netflix a soli 6,99 €.</b>
                    <br> 
                    Approfitta del nostro piano con pubblicità: è il più conveniente.
                </span>
                <button onclick="redirectToAdsPlan()">Scopri di più</button>
            </div>
        </div>
    <div class="section-title">
        <h2>I titoli del momento</h2>
        <div class="grid">
            <div class="card">
                <img src="{{ URL::to('images/film-1.jpg') }}" alt="">
                <div class="rank">1</div>
                <span>Aggiunto di recente</span>
            </div>
            <div class="card">
                <img src="{{ URL::to('images/film-2.jpg') }}" alt="">
                <div class="rank">2</div>
                <span>Aggiunto di recente</span>
            </div>
            <div class="card">
                <img src="{{ URL::to('images/film-3.jpg') }}" alt="">
                <div class="rank">3</div>
                <span>Aggiunto di recente</span>
            </div>
            <div class="card">
                <img src="{{ URL::to('images/film-4.jpg') }}" alt="">
                <div class="rank">4</div>
                <span>Aggiunto di recente</span>
            </div>
            <div class="card">
                <img src="{{ URL::to('images/film-5.jpg') }}" alt="">
                <div class="rank">5</div>
                <span>Aggiunto di recente</span>
            </div>
            <div class="card">
                <img src="{{ URL::to('images/film-6.jpg') }}" alt="">
                <div class="rank">6</div>
                <span>Aggiunto di recente</span>
            </div>
            <div class="card">
                <img src="{{ URL::to('images/film-7.jpg') }}" alt="">
                <div class="rank">7</div>
                <span>Aggiunto di recente</span>
            </div>
            <div class="card">
                <img src="{{ URL::to('images/film-8.jpg') }}" alt="">
                <div class="rank">8</div>
                <span>Aggiunto di recente</span>
            </div>
            <div class="card">
                <img src="{{ URL::to('images/film-9.jpg') }}" alt="">
                <div class="rank">9</div>
                <span>Aggiunto di recente</span>
            </div>
        </div>
    </div>
    </section>
    <!-- FEATURES -->
    <section class="features">
        <h2 class="section-title">Motivi in più per abbonarsi</h2>
            <div class="features-grid">
            <div class="feature-card">
                <h3 class="feature-title">Goditi Netflix sulla tua TV</h3>
                <p class="feature-description">Guarda Netflix su smart TV, Playstation, Xbox, Chromecast, Apple TV, lettori Blu-ray e molti altri dispositivi.</p>
                <img src="{{ URL::to('images/feature-1.png') }}" alt="" class="feature-icon">
            </div>
            <div class="feature-card">
                <h3 class="feature-title">Scarica le tue serie da guardare offline</h3>
                <p class="feature-description">Salva facilmente i tuoi preferiti così avrai sempre qualcosa da guardare.</p>
                <img src="{{ URL::to('images/feature-2.png') }}" alt="" class="feature-icon">
            </div>
            <div class="feature-card">
                <h3 class="feature-title">Guarda Netflix ovunque</h3>
                <p class="feature-description">Cellulare, tablet, laptop e TV: scegli tu cosa usare per guardare in streaming film e serie TV senza limiti.</p>
                <img src="{{ URL::to('images/feature-3.png') }}" alt="" class="feature-icon">
            </div>
            <div class="feature-card">
                <h3 class="feature-title">Crea profili per i bambini</h3>
                <p class="feature-description">I bambini scoprono nuove avventure in compagnia dei loro personaggi preferiti in uno spazio tutto loro già incluso nel tuo abbonamento.</p>
                <img src="{{ URL::to('images/feature-4.png') }}" alt="" class="feature-icon">
            </div>
        </div>
    </section>
    <!-- FAQ -->
    <section class="faq">
        <h2 class="section-title">Domande frequenti</h2>
        <ul class="accordion">
            <li>
                <button id="qst1">Cos'è Netflix?
                    <img src="{{ URL::to('images/icons8-x-50.png') }}">
                </button>
                <div class="content">
                    <p>Netflix è un servizio di streaming che offre una varietà di serie TV, film, documentari pluripremiati e tanto altro su una vasta gamma di dispositivi connessi a Internet.
                        Guarda quello che vuoi, quando vuoi. Il tutto a una quota mensile ridotta. C'è sempre qualcosa di nuovo da scoprire: aggiungiamo nuovi film e serie TV ogni settimana!</p>
                </div>
            </li>
            <li>
                <button id="qst2">Quanto costa Netflix?
                    <img src="{{ URL::to('images/icons8-x-50.png') }}">
                </button>
                <div class="content">
                    <p>Guarda Netflix su smartphone, tablet, Smart TV, laptop o dispositivi per lo streaming, il tutto per un importo mensile fisso.
                        Piani da 17,99 € a 5,49 € al mese. Nessun costo aggiuntivo, nessun contratto.</p>
                </div>
            </li>
            <li>
                <button id="qst3">Dove posso guardare Netflix?
                    <img src="{{ URL::to('images/icons8-x-50.png') }}">
                </button>
                <div class="content">
                    <p>Guarda Netflix dove vuoi, quando vuoi. Accedi al tuo account per guardare subito Netflix dal tuo computer su netflix.com oppure da qualsiasi dispositivo connesso a Internet che supporta l'app Netflix, come smart TV, smartphone, tablet, lettori multimediali per streaming e console per videogiochi.
                        Con l'app per iOS, Android e Windows 10 puoi anche scaricare i tuoi programmi preferiti. Usa la funzionalità di download per guardare i contenuti mentre sei in viaggio e senza connessione a Internet. Porta Netflix sempre con te.</p>
                </div>
            </li>
            <li>
                <button id="qst4">Come posso disdire?
                    <img src="{{ URL::to('images/icons8-x-50.png') }}">
                </button>
                <div class="content">
                    <p>Netflix è flessibile. Nessun contratto fastidioso e nessun impegno. Puoi facilmente disdire il tuo contratto online con due clic.
                        Nessuna penale: attiva o disdici il tuo account in qualsiasi momento.</p>
                </div>
            </li>
            <li>
                <button id="qst5">Cosa posso guardare su Netflix?
                    <img src="{{ URL::to('images/icons8-x-50.png') }}">
                </button>
                <div class="content">
                    <p>Netflix ha un nutrito catalogo di lungometraggi, documentari, serie TV, anime, originali Netflix pluripremiati e tanto altro. Guarda tutto quello che vuoi, in qualsiasi momento.</p>
                </div>
            </li>
            <li>
                <button id="qst6">Netflix è adatto ai bambini?
                    <img src="{{ URL::to('images/icons8-x-50.png') }}">
                </button>
                <div class="content">
                    <p>L'area Netflix Bambini, già inclusa nell'abbonamento, offre ai genitori un maggiore controllo sui contenuti e ai più piccoli uno spazio dedicato dove guardare serie TV e film per tutta la famiglia.
                        I profili Bambini hanno un filtro famiglia con PIN che ti permette di limitare l'accesso ai contenuti in base alla fascia d'età e bloccare la visione di titoli specifici.</p>
                </div>
            </li>
        </ul>
        <p class="email-form-title">Vuoi guardare Netflix? Inserisci l'indirizzo email per abbonarti o riattivare il tuo abbonamento.</p>
        <div class="email-signup">
            <div class="form-control">
                <input type="email" id="signup-email-2" name="email" required>
                <label for="email_phone">Indirizzo Email</label>
            </div>
            <a>
                <button disabled type="submit" id="signup-btn-2">Inizia ></button>
            </a>
        </div>
    </section>
    <!-- FOOTER -->
    <footer>
        <h2>Domande? Chiama 800-130-364</h2>
        <div class="row">
            <div class="col">
                <a href="https://help.netflix.com/it/node/412">Domande frequenti</a>
                <a href="https://ir.netflix.net/ir-overview/profile/default.aspx">Rapporti con gli investitori</a>
                <a href="https://help.netflix.com/it/node/14361">Come guardare Netflix</a>
                <a href="https://help.netflix.com/it/node/134094">Informazioni sull'azienda</a>
            </div>
            <div class="col">
                <a href="https://help.netflix.com/it">Centro assistenza</a>
                <a href="https://jobs.netflix.com/">Opportunità di lavoro</a>
                <a href="https://help.netflix.com/legal/termsofuse">Condizioni di utilizzo</a>
                <a href="https://help.netflix.com/it/contactus">Contattaci</a>
            </div>
            <div class="col">
                <a href="{{ URL::to('login') }}">Account</a>
                <a href="https://www.netflix.com/it/redeem">Riscatta carte regalo</a>
                <a href="https://help.netflix.com/legal/privacy">Privacy</a>
                <a href="https://fast.com/it/">Test di velocità</a>
            </div>
            <div class="col">
                <a href="https://media.netflix.com/it/">Media Center</a>
                <a href="https://www.netflix.com/gift-cards">Acquista carte regalo</a>
                <a href="#">Preferenze per i cookie</a>
                <a href="https://help.netflix.com/it/node/125888">Garanzia legale</a>
            </div>
        </div>
        <div class="footer-language-select">
            <select class="language-select">
                <option value="it">Italiano</option>
                <option value="en">English</option>
            </select>
        </div>
        <p class="copyright-txt">Netflix Italia</p>
    </footer>
</body>

</html>