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

    if (!is_array($email) && !is_array($password) && $stmt->execute()) {
        $stmt->store_result();
        $stmt->bind_result($hash_pwd);
        $stmt->fetch();

        $hashed_password = creaHash($password);
        if ($hashed_password === $hash_pwd) {
            $time = time() + 86400 * 30;
            setcookie("email", $email, $time, "/");
            setcookie("session", creaCookie($email, $hashed_password), $time, "/");
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
