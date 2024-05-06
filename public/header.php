<div class="pre-header-container">
    <header class="pre-header">
        <h5>Sito dell'Aula Magna</h5>
        <nav class="nav-bar-pre-header">
            <?php
            if (controllaSeLoggato()) {
                echo '<a href="' . generaLinkRisorsa("public/profilo.php") . '" class="user-link"><img  src="' . generaLinkRisorsa("resources/icons/user.png") . '" class="user-icon"></a>';
                echo '<a href="' . generaLinkRisorsa("public/logout.php") . '" class="user-link"><img src="' . generaLinkRisorsa("resources/icons/logout.png") . '" class="user-icon"></a>';
            } else {
                echo '<a href="' . generaLinkRisorsa("public/login.php") . '" class="user-link"><img src="' . generaLinkRisorsa("resources/icons/login.png") . '" class="user-icon"></a>';
                echo '<a href="' . generaLinkRisorsa("public/registrazione.php") . '" class="user-link"><img src="' . generaLinkRisorsa("resources/icons/sign_up.svg") . '" class="user-icon"></a>';
            }
            ?>

        </nav>
    </header>
</div>

<div class="header-container">
    <header class="header">
        <?php
        echo '<a href="https://www.ittgiorgi.edu.it/"> <img src="' . generaLinkRisorsa("resources/LogoGiorgi.png") . '" alt="" class="logo"></img></a>';
        ?>
        <nav class="nav-bar">
            <?php
            echo '<a href="' . generaLinkRisorsa("") . '">Home</a>';
            if (controllaSeLoggato()) {
                if (controllaSeAdmin()) {
                    echo '<a href="' . generaLinkRisorsa("public/prenotazioni_admin.php?ID=type-nonvisionati");
                    echo '">Prenotazioni Admin</a>';
                }
                echo '<a href="' . generaLinkRisorsa("public/prenotazione.php") . '">Prenota</a>';
            }
            echo '<a href="' . generaLinkRisorsa("public/calendario.php") . '">Calendario</a>';
            ?>
        </nav>
        <div class="menu-toggle" onclick="toggleMobileMenu()">
            <i class="fas fa-bars"></i>
        </div>
    </header>
    <div class="mobile-menu" id="mobileMenu">
        <?php
        if (controllaSeLoggato()) {
            if (controllaSeAdmin()) {
                echo '<a href="' . generaLinkRisorsa("public/prenotazioni_admin.php?ID=type-nonvisionati");
                echo '">Prenotazioni <br>Admin</a>';
            }
            echo '<a href="' . generaLinkRisorsa("public/prenotazione.php") . '">Prenota</a>';
            echo '<a href="' . generaLinkRisorsa("public/profilo.php") . '">Profilo</a>';
            echo '<a href="' . generaLinkRisorsa("public/logout.php") . '">Esci</a>';
        } else {
            echo '<a href="' . generaLinkRisorsa("public/login.php") . '">Accedi</a>';
            echo '<a href="' . generaLinkRisorsa("public/registrazione.php") . '">Registrati</a>';
        }
        echo '<a href="' . generaLinkRisorsa("public/calendario.php") . '">Calendario</a>';
        ?>
    </div>
</div>