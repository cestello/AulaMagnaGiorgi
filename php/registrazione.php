<?php
/*
REGISTRAZIONE
    Nome
    Cognome
    Email
    Pwd
*/

include('../util/utils.php');

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $nome = $_POST["Nome"];
    $cognome = $_POST["Nognome"];
    $email = $_POST["Email"];
    $password = $_POST["Password"];
    $value = is_mail_valid($email);

    if ($value != 0) 
    {
        if($value == 1) 
        {
            echo("La lunghezza deve essere tra 7 e 128 caratteri");
        }
        else 
        {
            echo("L'email inserita non e' valida");
        }
    } 
    else if (!is_used($email))
    {
        $status_code = is_valid($password);
        if ($status_code == 0)
        {
            // TODO: manda al database
            $conn = connect_to_database();
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } else {
                $sql_query = "INSERT INTO utenti (email, passoword, nome, cognome, admin)
                VALUES (" . $email . ", " . $password . ", " . $nome . ", " . $cognome . ", 0);";
                echo(sql_query);
                $query_answer = $conn->query($sql_query);
                if($query_answer === FALSE) {
                    echo("Errore non previsto nella registrazione");
                }
                $conn->close();
            }
            // TODO: redirect al login
            // echo("Redirect al login");
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
