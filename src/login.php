<?php

/**
 * Effettua il login
 *
 * @param mysqli $conn connessione al database
 * @param string $email dell'utente
 * @param string $password dell'utente
 */
function effettuaLogin($conn, $email, $password)
{
    $sql_query = "SELECT password FROM utenti WHERE email = '" . $email . "';";

    $query_answer = $conn->query($sql_query);
    if ($query_answer === false) {
        $_SESSION['message'] = "Errore nel Login";
    } else {
        $row = $query_answer->fetch_assoc();
        $db_password = $row["password"];
        if (hash('sha256', $password) === $db_password) {
            setcookie("user", $email, time() + 86400 * 30, "/");
            setcookie("pass", $db_password, time() + 86400 * 30, "/");
            $conn->close();
            header("Location: " . generaLinkRisorsa());
            die();
        } else {
            $_SESSION['message'] = "Password errata";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["username"];
    $password = $_POST["password"];

    if (isMailUsed($email, connectToDatabase())) {
        effettuaLogin(connectToDatabase(), $email, $password);
    } else {
        $_SESSION['message'] = "Account inesistente";
    }
}
