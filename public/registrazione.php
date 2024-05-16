<?php
session_abort();
session_start();

include_once "../src/utils.php";
include_once "../src/check_cookie.php";

// Se l'utente è loggato, viene reindirizzato all'index
if (controllaSeLoggato()) {
    header("Location: " . generaLinkRisorsa());
    die();
}

include_once "../src/registrazione.php";

?>

<!DOCTYPE html>
<html lang="it-IT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <?php
    echo collegaCSS("registrazione");
    echo collegaCSS("style");
    echo collegaCSS("index");
    ?>
    
    <title>
        Registrazione Account
    </title>


</head>

<body>
    <?php include_once "./header.php"; ?>

    
    <form method="post" id="FormRegistrazione">
        <h1>Registrazione</h1>

        <label for="Nome">Nome:
            <span class="fa-regular fa-circle-question" onmouseover="nomeinfo(true)" onmouseout="nomeinfo(false)">
            </span>
            <span id="infonome" class="display notDisplay">
                Numero minimo di caratteri: 2<br>
                Numero massimo di caratteri: 64
            </span>
        </label>
        <input type="text" id="Nome" name="Nome" minlength="2" maxlength="64" required>


        <label for="Cognome">Cognome:
            <span class="fa-regular fa-circle-question" onmouseover="cognomeinfo(true)" onmouseout="cognomeinfo(false)">
            </span>
            <span id="infocognome" class="display notDisplay">
                Numero minimo di caratteri: 2<br>
                Numero massimo di caratteri: 64
            </span>
        </label>
        <input type="text" id="Cognome" name="Cognome" minlength="2" maxlength="64" required>

        <label for="Email">Email: <span class="fa-regular fa-circle-question" onmouseover="emailinfo(true)" onmouseout="emailinfo(false)"></span>
            <span id="infoemail" class="display notDisplay">
                Numero minimo di caratteri: 7<br>
                Numero massimo di caratteri: 128
            </span>
        </label>
        <input type="email" id="Email" name="Email" minlength="7" maxlength="128" required>

        <label for="Password">Password: <span class="fa-regular fa-circle-question" onmouseover="passwordinfo(true)" onmouseout="passwordinfo(false)"></span>
            <span id="infopassword" class="display notDisplay">
                Numero minimo di caratteri: 8<br>
                Numero massimo di caratteri: 64<br>
                Almeno una lettera maiuscola<br>
                Almeno una lettera minuscola<br>
                Almeno un numero<br>
                Almeno un carattere speciale: #?!@$%^&*-
            </span>
        </label>
        <input type="password" id="Password" name="Password" minlength="8" maxlength="64" required>

        <label for="ConfermaPassword">Conferma Password: </label>
        <input type="password" id="ConfermaPassword" name="ConfermaPassword" required>

        <?php
        echo '<a id="forgot-pass" href="' . generaLinkRisorsa("public/login.php");
        echo '">Hai gi&agrave; un account? Accedi</a>';
        ?>
        <br>

        <input type="submit" name="Invia">
        <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
        }
        unset($_SESSION['message']);
        ?>
    </form>
    
        <?php //include_once "./footer.php"; ?>
    
    <script src="https://kit.fontawesome.com/a8d5f6e743.js" crossorigin="anonymous"></script>
    <script>
        function nomeinfo() {
            let element = document.getElementById("infonome");
            element.classList.toggle("notDisplay");
        }

        function cognomeinfo() {
            let element = document.getElementById("infocognome");
            element.classList.toggle("notDisplay");
        }

        function emailinfo() {
            let element = document.getElementById("infoemail");
            element.classList.toggle("notDisplay");
        }

        function passwordinfo() {
            let element = document.getElementById("infopassword");
            element.classList.toggle("notDisplay");
        }


        function toggleMobileMenu() {
            var mobileMenu = document.getElementById("mobileMenu");
            var menuToggle = document.querySelector(".menu-toggle");

            if (mobileMenu.style.display === "block") {
                mobileMenu.style.display = "none";
                menuToggle.innerHTML = '<i class="fas fa-bars"></i>'; // Ripristina l'icona del menu
                menuToggle.style.transform = "rotate(0deg)";
            } else {
                mobileMenu.style.display = "block";
                menuToggle.innerHTML = '<i class="fas fa-times"></i>'; // Mostra la "x" per chiudere il menu
                menuToggle.style.transform = "rotate(90deg)";
            }
        }
    </script>

    
</body>

</html>
