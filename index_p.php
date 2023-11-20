<?php
/*
REGISTRAZIONE
    Nome
    Cognome
    Email
    Pwd
*/

include('./utils.php');

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (!is_used($email))
    {
        $status_code = is_valid($password);
        if ($status_code == 0)
        {
            // TODO: manda al database
            // TODO: redirect al login
            echo("Redirect su login");
        }
        else if ($status_code == 1)
        {
            echo("La lunghezza deve essere tra 8 e 32 caratteri");
        }
        else if ($status_code == 2)
        {
            echo("Parametri non rispettati:
                            almeno una maiuscola,
                            almeno una minuscola,
                            almeno un numero,
                            almeno un carattere speciale [#?!@$%^&*-]");
        }
    }
    else
    {
        echo("Email gi&agrave; utilizzata");
    }
}