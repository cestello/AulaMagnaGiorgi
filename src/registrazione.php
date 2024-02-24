<?php

/**
 * Resistuisce messaggi in base al codice di errore
 * riguardanti l'input dell'email
 *
 * @param int $code codice di errore
 */
function messaggioMailNonValida($code)
{
    if ($code == 1) {
        $_SESSION['message'] = "La lunghezza dell'email deve essere tra 7 e 128 caratteri";
    } elseif ($code == 2) {
        $_SESSION['message'] = "L'email inserita non &egrave; valida";
    }
}

/**
 * Restituisce messaggi basati sul codice di errore
 * sull'input della password
 *
 * @param int $code codice di errore
 */
function messaggioPasswordNonValida($code)
{
    if ($code == 1) {
        $_SESSION['message'] = "La lunghezza della password deve essere tra 8 e 32 caratteri";
    } elseif ($code == 2) {
        $_SESSION['message'] = "Parametri non rispettati:
            almeno una maiuscola,
            almeno una minuscola,
            almeno un numero,
            almeno un carattere speciale #?!@$%^&*-";
    } else {
        $_SESSION['message'] = "Le password inserite sono diverse";
    }
}

/**
 * Effettua la registrazione di un utente
 *
 * @param mysqli $conn oggetto connessione
 * @param string $email dell'utente
 * @param string $password dell'utente
 * @param string $nome dell'utente
 * @param string $cognome dell'utente
 * @return bool se la registrazione è andata a buon fine
 */
function registra($conn, $email, $password, $nome, $cognome)
{
    $sql_query = "INSERT INTO utenti (email, password, nome, cognome, admin)
    VALUES ('" . $email . "', '" . hash('sha256', $password) . "', '" . $nome . "', '" . $cognome . "', 0);";
    
    $query_answer = $conn->query($sql_query);
    if ($query_answer === false) {
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
    $value = isMailValid($email);

    if ($value != 0) {
        messaggioMailNonValida($value);
    } else {
        $conn = connectToDatabase();
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $is_successful = false;
        if (!isMailUsed($email, $conn)) {
            $status_code = isPasswordValid($password, $confirm_password);
            if ($status_code != 0) {
                messaggioPasswordNonValida($status_code);
            } else {
                $is_successful = registra($conn, $email, $password, $nome, $cognome);
            }
        } else {
            $_SESSION["message"] = "Email gi&agrave utilizzata";
        }
        $conn->close();

        if ($is_successful) {
            header("Location: " . MAINURL . "public/login.php");
        }
    }
}
