<?php
/*
    LOGIN
    Email
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
        echo("Accesso effettuato con successo");
    }
    else
    {
        echo("Account inesistente");
    }
}
