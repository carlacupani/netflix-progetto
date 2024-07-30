<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- primary meta tags -->
    <title>Accedi a Netflix</title>
    <meta name="title" content="Netflix">
    <!-- favicon -->
    <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">
    <!-- google font link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap" rel="stylesheet">
    <!-- css link -->
    <link rel='stylesheet' href='{{ URL::to("css/login.css") }}'>
    <!-- js link -->
</head>

<body>
    <!--HEADER-->
    <header>
        <nav>
            <a href="{{ URL::to('index') }}">
                <img id="logo1" src="{{ URL::to('images/logo.png') }}" class="logo1" alt="Netflix Logo">
            </a>
        </nav>
        <!--LOGIN FORM-->
        <div class="header-content">
            <div class="login-body">
                <h2 class="title">Accedi</h2>
                <form name="login" method="post" enctype="multipart/form-data" action="#" class="login-form" autocomplete="off">
                @csrf
                    <!-- Seleziono il valore di ogni campo sulla base dei valori inviati al server via POST -->
                    <div class="form-control">
                        <input type="text" name="email" value='{{ old("email") }}' required />
                        <label for="email_phone">Indirizzo Email</label>
                    </div>
                    <div class="form-control">
                        <input type="password" name="password" value='{{ old("password") }}' required />
                        <label for="password">Password</label>
                    </div>
                    <button type="submit" >Accedi</button>
                    <div class="form-help">
                        <div class="remember-me">
                            <input type="checkbox" id="remember-me" />
                            <label for="remember-me">Ricordami</label>
                        </div>
                        <a href="#">Hai dimenticato la password?</a>
                    </div>
                </form>
                <p class="sign-up">Prima volta su Netflix? <a href="{{ URL::to('signup') }}" >Registrati</a></p>
                <p class="short-desc">
                    Questa pagina è protetta da Google reCAPTCHA per garantire che tu non sia un bot.
                    <a href="#">Scopri di più.</a>
                </p>
            </div>
        </div>
    </header>
    <!--FOOTER-->
    <footer>
        <h2>Domande? Chiama 800-130-364</h2>
        <div class="row">
            <div class="col">
                <a href="#">Domande frequenti</a>
                <a href="#">Condizioni di utilizzo</a>
                <a href="#">Preferenze per i cookie</a>
                <a href="#">Preferenze per la pubblicità</a>
            </div>
            <div class="col">
                <a href="#">Centro assistenza</a>
                <a href="#">Informazioni sull'azienda</a>
                <a href="#">Privacy</a>
                <a href="#"> </a>
            </div>
        </div>
        <p class="copyright-txt">Netflix Italia</p>
    </footer>

</body>

</html>