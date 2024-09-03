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
            <h3>Guarda ciò che vuoi ovunque. Disdici quando vuoi.</h3>
            <p>Vuoi guardare Netflix? Inserisci l'indirizzo email per abbonarti o riattivare il tuo abbonamento.</p>
            <div class="email-signup" >
                <div class="form-control">
                    <input type="email" id="signup-email-1" name="email" required>
                    <label for="email_phone">Indirizzo Email</label>
                </div>
                <a >
                    <button disabled type="submit" id="signup-btn-1">Inizia</button>
                </a>
            </div>
        </div>
    </header>
    <!-- SECTION 1 -->
    <section>
        <div class="row">
            <div class="text-col">
                <h2>Goditi Netflix sulla tua TV</h2>
                <p>Guarda Netflix su smart TV, Playstation, Xbox, Chromecast, Apple TV, lettori Blu-ray e molti altri
                    dispositivi.</p>
            </div>
            <div class="img-col">
                <img src="{{ URL::to('images/feature-1.png') }}">
            </div>
        </div>
    </section>
    <!-- SECTION 2 -->
    <section>
        <div class="row">
            <div class="img-col">
                <img src="{{ URL::to('images/feature-3.png') }}">
            </div>
            <div class="text-col">
                <h2>Guarda Netflix ovunque</h2>
                <p>Cellulare, tablet, laptop e TV: scegli tu cosa usare per guardare in streaming film e serie TV senza limiti.</p>
            </div>
        </div>
    </section>
    <!-- SECTION 3 -->
    <section>
        <div class="row">
            <div class="text-col">
                <h2>Crea profili per i bambini</h2>
                <p>I bambini scoprono nuove avventure in compagnia dei loro personaggi preferiti in uno spazio tutto loro già incluso nel tuo abbonamento.</p>
            </div>
            <div class="img-col">
                <img src="{{ URL::to('images/feature-4.png') }}">
            </div>
        </div>
    </section>
    <!-- SECTION 4 -->
    <section>
        <div class="row">
            <div class="img-col">
                <img src="{{ URL::to('images/feature-2.png') }}">
            </div>
            <div class="text-col">
                <h2>Scarica le tue serie da guardare offline</h2>
                <p>Guarda in aereo, sul treno, in astronave...</p>
            </div>
        </div>
    </section>
    <!-- FAQ -->
    <div class="faq">
        <h2>Domande frequenti</h2>
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
        <small>Vuoi guardare Netflix? Inserisci l'indirizzo email per abbonarti o riattivare il tuo abbonamento.</small>
        <div class="email-signup">
            <div class="form-control">
                <input type="email" id="signup-email-2" name="email" required>
                <label for="email_phone">Indirizzo Email</label>
            </div>
            <a >
                <button disabled type="submit" id="signup-btn-2">Inizia</button>
            </a>
        </div>
    </div>
    <!-- FOOTER -->
    <footer>
        <h2>Domande? Chiama 800-130-364</h2>
        <div class="row">
            <div class="col">
                <a href="https://help.netflix.com/it/node/412">Domande frequenti</a>
                <a href="https://help.netflix.com/it">Centro assistenza</a>
                <a href="{{ URL::to('login') }}">Account</a>
                <a href="https://media.netflix.com/it/">Media Center</a>
            </div>
            <div class="col">
                <a href="https://ir.netflix.net/ir-overview/profile/default.aspx">Rapporti con gli investitori</a>
                <a href="https://jobs.netflix.com/">Opportunità di lavoro</a>
                <a href="https://www.netflix.com/it/redeem">Riscatta carte regalo</a>
                <a href="https://www.netflix.com/gift-cards">Acquista carte regalo</a>
            </div>
            <div class="col">
                <a href="https://help.netflix.com/it/node/14361">Come guardare Netflix</a>
                <a href="https://help.netflix.com/legal/termsofuse">Condizioni di utilizzo</a>
                <a href="https://help.netflix.com/legal/privacy">Privacy</a>
                <a href="#">Preferenze per i cookie</a>
            </div>
            <div class="col">
                <a href="https://help.netflix.com/it/node/134094">Informazioni sull'azienda</a>
                <a href="https://help.netflix.com/it/contactus">Contattaci</a>
                <a href="https://fast.com/it/">Test di velocità</a>
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