<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Account Netflix</title>
    <meta name="title" content="Netflix">
    <!-- FAVICON -->
    <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">
    <!-- GOOGLE FONT LINK -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap" rel="stylesheet">
    <!-- CSS LINK -->
    <link rel="stylesheet" href='{{ URL::to("css/edit_profile.css") }}'>
    <!-- JS LINK -->
    <script src='{{ URL::to("js/edit_profile.js") }}' defer></script>
</head>

<body>
    <!-- HEADER -->
    <header>
        <nav>
            <a href="{{ URL::to("home") }}">
                <img id="logo1" src='{{ URL::to("images/logo.png") }}' class="logo1">
            </a>
        </nav>
        <!-- EDIT ACCOUNT FORM -->
        <div class="header-content">
            <div class="edit-account-body">
                <h2 class="title">Modifica Profilo</h2>
                <form name="edit" method="post" enctype="multipart/form-data" action="#" class="edit-account-form" autocomplete="off">
                    <input type="hidden" name="current_avatar" />
                    <div class="form-control">
                        <div class="name">
                            <input type="text" name="name"  required />
                            <label for="name">Nome</label>
                        </div>
                    </div>
                    <div class="form-control">
                        <div class="surname">
                            <input type="text" name="surname"  required />
                            <label for="surname">Cognome</label>
                        </div>
                    </div>
                    <div class="form-control">
                        <div class="username">
                            <input type="text" name="username"  required />
                            <label for="username">Username</label>
                        </div>
                    </div>
                    <div class="form-control">
                        <div class="email">
                            <input type="text" name="email"  required />
                            <label for="email">Indirizzo Email</label>
                        </div>
                    </div>
                    <div class="form-control">
                        <div class="password">
                            <input type="password" name="new_password" />
                            <label for="new_password">Nuova Password</label>
                        </div>
                    </div>
                    <div class="form-control">
                        <div class="confirm_password">
                            <input type="password" name="confirm_new_password" />
                            <label for="confirm_new_password">Conferma Nuova Password</label>
                        </div>
                    </div>
                    <div class="container-btn">
                        <button class="edit-account-btn" type="submit">Salva</button>
                    </div>
                </form>
                <div class="container-btn">
                    <a href="{{ URL::to("profile") }}">
                        <button class="edit-account-btn">Annulla</button>
                    </a>
                </div>
            </div>