<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- TOKEN -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Modifica Profilo Netflix</title>
    <meta name="title" content="Netflix">
    <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link rel='stylesheet' href='{{ URL::to("css/signup.css") }}'>
    </script>
    <!-- JS -->
    <script src='{{ URL::to("js/signup.js") }}' defer></script>
</head>

<body>
    <!--HEADER-->
    <header>
        <nav>
            <a href="{{ URL::to('index') }}">
            <img id="logo1" src="{{ URL::to('images/logo.png') }}" class="logo1">
            </a>
        </nav>
        <!--LOGIN FORM-->
        <div class="header-content">
            @foreach($errors->all() as $error)
            <div class="alert alert-error">
                {{ $error }}
                <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
            </div>
            @endforeach
            <div class="login-body">
                <h2 class="title">Registrati</h2>
                <form name="signup" method="post" enctype="multipart/form-data" action="#" class="login-form" autocomplete="off">
                    @csrf
                    <div class="form-control">
                        <div class="name">
                            <!-- Se il submit non va a buon fine, il server reindirizza su questa stessa pagina, quindi va ricaricata con 
                            i valori precedentemente inseriti -->
                            <input type="text" name="name" value='{{ old("name") }}' required />
                            <label for="name">Nome</label>
                        </div>
                    </div>
                    <div class="form-control">
                        <div class="surname">
                            <input type="text" name="surname" value='{{ old("surname") }}' required />
                            <label for="surname">Cognome</label>
                        </div>
                    </div>
                    <div class="form-control">
                        <div class="username">
                        <input type="text" name="username" value='{{ old("username") }}' required />
                        <span class="username"></span>
                        <label for="username">Username</label>
                        </div>
                    </div>
                    <div class="form-control">
                        <div class="email">
                            <input type="text" name="email" value='{{ old("email") }}' required />
                            <span class="email"></span>
                            <label for="email">Indirizzo Email</label>
                        </div>
                    </div>
                    <div class="form-control">
                        <div class="password">
                            <input type="password" name="password" value='{{ old("password") }}' required />
                            <label for="password">Password</label>
                        </div>
                    </div>
                    <div class="form-control">
                        <div class="confirm_password">
                            <input type="password" name="confirm_password" value='{{ old("confirm_password") }}' required />
                            <label for="confirm_password">Conferma la password</label>
                        </div>
                    </div>
                    <!-- <div class="form-control">
                        <div class="fileupload" >
                            <input type="file" name="avatar" accept='.jpg, .jpeg, image/gif, image/png, .png' id="upload_original"/>
                            <div id="upload">
                                <div class="file_name">Seleziona un file...</div>
                                <div class="file_size"></div>
                            </div>
                            <span>Le dimensioni del file superano 7 MB</span>
                        </div>
                    </div>
                    -->
                    <div class="form-help">
                        <div class="allow" value="1" {{ old('allow') ? 'checked' : '' }} >
                            <label for="allow">Accetto i termini e condizioni d'uso</label>
                            <input type="checkbox" name="allow" id="allow">
                        </div>
                        <a href="#">Hai dimenticato la password?</a>
                    </div>

                    <button id="register" type="submit">Registrati</button>
                </form>
                <p class="sign-up">Hai già un account Netflix? <a href="{{ URL::to('login') }}" >Accedi</a></p>
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