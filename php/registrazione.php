<?php
/*
REGISTRAZIONE
    Nome
    Cognome
    Email
    Pwd
*/

include('../util/utils.php');

function mail_wrong($code)
{
    if ($code == 1) 
    {
        echo ("La lunghezza deve essere tra 7 e 128 caratteri");
    } 
    else if ($code == 2)
    {
        echo ("L'email inserita non e' valida");
    }
    else
    {
        echo ("Email gi&agrave; utilizzata");
    }
}

function password_wrong($code) {
    if ($code == 1) 
    {
        echo ("La lunghezza deve essere tra 8 e 32 caratteri");
    } 
    else if ($code == 2) 
    {
        echo ("Parametri non rispettati:
            almeno una maiuscola,
            almeno una minuscola,
            almeno un numero,
            almeno un carattere speciale [#?!@$%^&*-]");
    } 
    else 
    {
        echo ("Le password inserite sono diverse");
    }
}

function registra($conn, $email, $password, $nome, $cognome)
{
    $sql_query = "INSERT INTO utenti (email, password, nome, cognome, admin)
    VALUES ('" . $email . "', '" . hash('sha256', $password) . "', '" . $nome . "', '" . $cognome . "', 0);";
    $query_answer = $conn->query($sql_query);
    if ($query_answer === FALSE) 
    {
        echo ("Errore non previsto nella registrazione");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $nome = $_POST["Nome"];
    $cognome = $_POST["Cognome"];
    $email = $_POST["Email"];
    $password = $_POST["Password"];
    $confirm_password = $_POST["ConfermaPassword"];
    $value = is_mail_valid($email);

    if ($value != 0) 
    {
        mail_wrong($value);
    } 
<<<<<<< HEAD
=======
    else if (!is_used($email))
    {
        $status_code = is_valid($password);
        if ($status_code == 0)
        {
            $conn = connect_to_database();
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } else {
                $sql_query = "INSERT INTO utenti (email, password, nome, cognome, admin)
                VALUES ('" . $email . "', '" . hash('sha256', $password) . "', '" . $nome . "', '" . $cognome . "', 0);";
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
>>>>>>> af2be3f3844cab71346e401da19b0c33ddcc517f
    else
    {
        $status_code = is_valid($password, $confirm_password);
        if ($status_code != 0) 
        {
            password_wrong($code);
        }
        else
        {
            $conn = connect_to_database();
            if ($conn->connect_error) 
            {
                die("Connection failed: " . $conn->connect_error);
            } 
            else 
            {
                registra($conn, $email, $password, $nome, $cognome);
            }
            $conn->close();
            header("Location: " . $url . "html/login.html");
            die();
        }
    }
}
