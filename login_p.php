<?php
/*
REGISTRAZIONE
    Nome
    Cognome
    Email
    Username
    Pwd
*/

include('./utils.php');

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (is_used($email))
    {
        // TODO: check is password is correct [database]
        echo("La password è corretta?");
    }
    else
    {
        echo("Account inesistente");
    }
}
