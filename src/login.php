<?php

/**
 * Effettua il login
 *
 * @param mysqli $conn connessione al database
 * @param string $email dell'utente
 * @param string $password dell'utente
 */
function effettuaLogin($email, $password)
{
    $conn = connectToDatabase();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT password FROM utenti WHERE email = ?");
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        $stmt->store_result();
        $stmt->bind_result($hash_pwd);
        $stmt->fetch();
        if (hash('sha256', $password) === $hash_pwd) {
            setcookie("user", $email, time() + 86400 * 30, "/");
            setcookie("pass", $hash_pwd, time() + 86400 * 30, "/");
            $stmt->close();
            $conn->close();
            header("Location: " . generaLinkRisorsa());
            die();
        } else {
            $_SESSION['message'] = "Password errata";
        }
    } else {
        $_SESSION['message'] = "Errore nel login";
    }
    $stmt->close();
    $conn->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["username"];
    $password = $_POST["password"];

    if (isMailUsed($email)) {
        effettuaLogin($email, $password);
    } else {
        $_SESSION['message'] = "Account inesistente";
    }
}
