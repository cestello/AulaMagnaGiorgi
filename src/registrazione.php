<?php

function invalid_mail_message($code)
{
    if ($code == 1) {
        $_SESSION['message'] = "La lunghezza dell'email deve essere tra 7 e 128 caratteri";
    } else if ($code == 2) {
        $_SESSION['message'] = "L'email inserita non &egrave; valida";
    }
}

function invalid_password_message($code)
{
    if ($code == 1) {
        $_SESSION['message'] = "La lunghezza della password deve essere tra 8 e 32 caratteri";
    } else if ($code == 2) {
        $_SESSION['message'] = "Parametri non rispettati:
            almeno una maiuscola,
            almeno una minuscola,
            almeno un numero,
            almeno un carattere speciale #?!@$%^&*-";
    } else {
        $_SESSION['message'] = "Le password inserite sono diverse";
    }
}

function registra($conn, $email, $password, $nome, $cognome)
{
    $sql_query = "INSERT INTO utenti (email, password, nome, cognome, admin)
    VALUES ('" . $email . "', '" . hash('sha256', $password) . "', '" . $nome . "', '" . $cognome . "', 0);";
    $query_answer = $conn->query($sql_query);
    if ($query_answer === FALSE) {
        $_SESSION['message'] = "Errore non previsto nella registrazione";
        return false;
    }
    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["Nome"];
    $cognome = $_POST["Cognome"];
    $email = $_POST["Email"];
    $password = $_POST["Password"];
    $confirm_password = $_POST["ConfermaPassword"];
    $value = is_mail_valid($email);

    if ($value != 0) {
        invalid_mail_message($value);
    } else {
        $conn = connect_to_database();
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $is_successful = false;
        if (!is_mail_used($conn, $email)) {
            $status_code = is_password_valid($password, $confirm_password);
            if ($status_code != 0) {
                invalid_password_message($status_code);
            } else {
                $is_successful = registra($conn, $email, $password, $nome, $cognome);
            }
        }

        $conn->close();
        if ($is_successful) {
            // $to = "francescosalvatore.rizzello.05@ittgiorgi.edu.it";
            // $subject = "PHP Mail Test";
            // $message = "Messaggio di test\r\n";
            // $headers = "From: vincenzo.cardea.05@ittgiorgi.edu.it";
            // if (mail($to, $subject, $message, $headers)) {
            //     echo "Messaggio inviato con successo!";
            // } else {
            //     echo "Errore nell'invio del messaggio.";
            // }
            header("Location: " . MAINURL . "public/login.php");
        }
    }
}
