<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione Account</title>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background: linear-gradient(to left, #b9cfec,  #b4c8d4);
        }
        #paper-window section {
            padding: 40px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin: 50px auto;
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
            border: 1px solid ;
            border-color: #3979cc;
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


        #FormRegistrazione img{
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

        .fa-circle-question:hover{
            color: #BC2047;
        }

        @media (min-width: 768px){

        }


        @media (max-width: 767px){
            #FormRegistrazione{
                max-width: 90%;
            }
            #FormRegistrazione img{
                width: 45%;
                height: 45%;
            }
            #FormRegistrazione h1{
                font-size: 30px;
            }
            #FormRegistrazione input {
                width: 100%;
                padding: 8px;
                margin-bottom: 18px;
                border-radius: 6px;
                box-sizing: border-box;
                border: 1px solid ;
                border-color: #3979cc;
            }
        }

        a {
            color: #BC2047;
            font-weight: bold;

        }
    </style>
</head>
<body>


<form id="FormRegistrazione" onsubmit="return ValidationForm()">

    <img src="../img/LogoGiorgi.png" alt="LogoGiorgi">

    <h1>Registrazione</h1>

    <label for="Nome">Nome: <span class="fa-regular fa-circle-question" onmouseover="nomeinfo(true)" onmouseout="nomeinfo(false)"></span>
        <div id="infonome" class="display notDisplay">
            Numero massimo di caratteri: 35.
        </div>
    </label>
    <input type="text" id="Nome" name="Nome"  required>


    <label for="Cognome">Cognome: <span class="fa-regular fa-circle-question" onmouseover="cognomeinfo(true)" onmouseout="cognomeinfo(false)"></span>
        <div id="infocognome" class="display notDisplay">
            Numero massimo di caratteri: 25.
        </div>
    </label>
    <input type="text" id="Cognome" name="Cognome"  required>

    <label for="Email">Email: <span class="fa-regular fa-circle-question" onmouseover="emailinfo(true)" onmouseout="emailinfo(false)"></span>
        <div id="infoemail" class="display notDisplay">
            Numero minimo di caratteri: 7.<br>
            Numero massimo di caratteri: 64.
        </div> </label>
    <input type="email" id="Email" name="Email"  required>

    <label for="Password">Password: <span class="fa-regular fa-circle-question" onmouseover="passwordinfo(true)" onmouseout="passwordinfo(false)"></span>
        <div id="infopassword" class="display notDisplay">
            Numero minimo di caratteri: 8.<br>
            Numero massimo di caratteri: 32.<br>
            Almeno una lettera maiuscola.<br>
            Almeno un numero.<br>
            Almeno un carattere speciale.
        </div></label>
    <input type="password" id="Password" name="Password"  required>

    <label for="ConfermaPassword">Conferma Password: </label>
    <input type="password" id="ConfermaPassword" name="ConfermaPassword"  required>
    <a  href="../Login/login.html" id="forgot-pass">Hai un account? Accedi</a> <br><br>

    <input type="submit" name="Invia">
</form>
<script src="https://kit.fontawesome.com/a8d5f6e743.js" crossorigin="anonymous"></script>
<script>
    function ValidationForm(){
        var Nome = document.getElementById("Nome").value;
        var Cognome = document.getElementById("Cognome").value;
        var Email = document.getElementById("Email").value;
        var Password = document.getElementById("Password").value;
        var ConfermaPassword = document.getElementById("ConfermaPassword").value;

        if (
            ControlloNome(Nome) &&
            ControlloCognome(Cognome) &&
            ControlloEmail(Email) &&
            ControlloPassword(Password) &&
            ControlloConfermaPassword(Password, ConfermaPassword)
        ) {
            // Tutti i controlli sono passati, puoi inviare il modulo
            alert("Registazione effettuata");
            return true;
        }

        // Se uno qualsiasi dei controlli fallisce, impedisci l'invio del modulo
        return false;
    }

    function ControlloNome(Nome){
        if(Nome.length > 35){
            alert("Il nome può avere massimo 35 caratteri.");
            return false;
        }
        return true;
    }

    function ControlloCognome(Cognome){
        if(Cognome.length > 25){
            alert("Il cognome può avere massimo 25 caratteri.");
            return false;
        }
        return true;
    }

    function ControlloEmail(Email){
        if (Email.length < 7) {
            alert("L'email deve contenere almeno 7 caratteri");
            return false;
        }
        if (Email.length > 64) {
            alert("L'email può contenere massimo 64 caratteri");
            return false;
        }
        return true;
    }

    function ControlloPassword(Password){
        if (Password.length < 8) {
            alert("La password deve contenere almeno 8 caratteri");
            return false;
        }
        if (Password.length > 32) {
            alert("La password può contenere massimo 32 caratteri");
            return false;
        }
        var contieneMaiuscola = /[A-Z]/;
        var contieneNumero = /\d/;
        var contieneSpeciale = /[!@#$%^&*()_+]/;

        if (!contieneMaiuscola.test(Password)) {
            alert("La password deve contenere almeno una lettera maiuscola");
            return false;
        }

        if (!contieneNumero.test(Password)) {
            alert("La password deve contenere almeno un numero");
            return false;
        }

        if (!contieneSpeciale.test(Password)) {
            alert("La password deve contenere almeno un carattere speciale");
            return false;
        }

        return true;
    }

    function ControlloConfermaPassword(Password, ConfermaPassword){
        if(Password !== ConfermaPassword){
            alert("La password non corrisponde");
            return false;
        }

        return true;
    }


    function nomeinfo()
    {
        let element = document.getElementById("infonome");
        element.classList.toggle("notDisplay");
    }

    function cognomeinfo()
    {
        let element = document.getElementById("infocognome");
        element.classList.toggle("notDisplay");
    }

    function emailinfo()
    {
        let element = document.getElementById("infoemail");
        element.classList.toggle("notDisplay");
    }

    function passwordinfo()
    {
        let element = document.getElementById("infopassword");
        element.classList.toggle("notDisplay");
    }


</script>
<script src="https://kit.fontawesome.com/a8d5f6e743.js" crossorigin="anonymous"></script>
<?php include("./signin_p.php"); ?>
</body>
</html>