<?php
session_abort();
session_start();
include('../src/utils.php');
include("../src/check_cookie.php");
if (check()) {
    header("Location: " . MAINURL . "index.php");
    die();
}
include("../src/registrazione.php");
?>

<!DOCTYPE html>
<html lang="it-IT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Registrazione Account
    </title>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background: linear-gradient(to left, #b9cfec, #b4c8d4);
        }

    
        #FormRegistrazione {
            max-width: 600px;
            margin: 4% auto;
            background: linear-gradient(to bottom, #b4c8d4, #3979cc);
            padding: 2%;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #FormRegistrazione h1 {
            text-align: center;
            color: #2370A6;
            font-size: 36px;
            margin-bottom: 33px;
            font-family: 'Open Sans', sans-serif;
        }

        #FormRegistrazione label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 18px;
            color: #ffffff;
        }

        #FormRegistrazione input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 6px;
            box-sizing: border-box;
            border: 1px solid #3979cc;
        }

        #FormRegistrazione input[type="submit"] {
            background-color: #043370;
            color: white;
            font-weight: bold;
            font-size: 17px;
            padding: 10px 15px;
            cursor: pointer;
            border: none;
            transition: .5s;

        }

        #FormRegistrazione input[type="submit"]:hover {
            background-color: #BC2047;
            transform: scale(1.03);
        }


        #FormRegistrazione img {
            display: block;
            margin: 0 auto;
            width: 243px;
            height: 138px;
        }


        .display {
            display: inline-block;
            margin-left: 10px;
            font-size: 12px;
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            color: #4b4b4b;
        }

        .notDisplay {
            display: none;
        }

        .fa-circle-question {
            color: #2370A6;
            transition: .5s;
        }

        .fa-circle-question:hover {
            color: #BC2047;
        }

        @media (min-width: 768px) {}


        @media (max-width: 767px) {
            #FormRegistrazione {
                max-width: 90%;
            }

            #FormRegistrazione img {
                width: 45%;
                height: 45%;
            }

            #FormRegistrazione h1 {
                font-size: 30px;
            }

            #FormRegistrazione input {
                width: 100%;
                padding: 8px;
                margin-bottom: 18px;
                border-radius: 6px;
                box-sizing: border-box;
                border: 1px solid #3979cc;
            }
        }

        a {
            color: #BC2047;
            font-weight: bold;

        }
    </style>
</head>

<body>
    <form method="post" id="FormRegistrazione">
        <a href="http://138.41.20.100/~rizzello2400/">
            <img src="../resources/LogoGiorgi.png" alt="LogoGiorgi">
        </a>

        <h1>Registrazione</h1>

        <label for="Nome">Nome: <span class="fa-regular fa-circle-question" onmouseover="nomeinfo(true)"
                onmouseout="nomeinfo(false)"></span>
            <span id="infonome" class="display notDisplay">
                Numero minimo di caratteri: 2<br>
                Numero massimo di caratteri: 64
            </span>
        </label>
        <input type="text" id="Nome" name="Nome" minlength="2" maxlength="64" required>


        <label for="Cognome">Cognome: <span class="fa-regular fa-circle-question" onmouseover="cognomeinfo(true)"
                onmouseout="cognomeinfo(false)"></span>
            <span id="infocognome" class="display notDisplay">
                Numero minimo di caratteri: 2<br>
                Numero massimo di caratteri: 64
            </span>
        </label>
        <input type="text" id="Cognome" name="Cognome" minlength="2" maxlength="64" required>

        <label for="Email">Email: <span class="fa-regular fa-circle-question" onmouseover="emailinfo(true)"
                onmouseout="emailinfo(false)"></span>
            <span id="infoemail" class="display notDisplay">
                Numero minimo di caratteri: 7<br>
                Numero massimo di caratteri: 128
            </span>
        </label>
        <input type="email" id="Email" name="Email" minlength="7" maxlength="128" required>

        <label for="Password">Password: <span class="fa-regular fa-circle-question" onmouseover="passwordinfo(true)"
                onmouseout="passwordinfo(false)"></span>
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
        <a href="./login.php" id="forgot-pass">Hai un account? Accedi</a> <br><br>

        <input type="submit" name="Invia">
        <?php
        if (isset($_SESSION['message'])) {
            echo ($_SESSION['message']);
        }
        unset($_SESSION['message']);
        ?>
    </form>
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
    </script>
    <script src="https://kit.fontawesome.com/a8d5f6e743.js" crossorigin="anonymous"></script>
</body>

</html>