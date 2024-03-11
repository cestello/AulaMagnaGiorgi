<?php

/**
 * Controlla se l'utente è loggato o meno basandosi sui cookie
 * di sessione
 *
 * @return bool se l'utente è loggato
 */
function controllaSeLoggato()
{
    $loggato = false;
    if (isset($_COOKIE['user']) && isset($_COOKIE['pass'])) {
        $email = $_COOKIE['user'];
        $hash_pwd = $_COOKIE['pass'];

        $conn = connectToDatabase();
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("SELECT password FROM utenti WHERE email = ?");
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            if ($stmt->store_result() && $stmt->num_rows > 0) {
                $stmt->bind_result($hash_pwd_db);
                $stmt->fetch();
                if ($hash_pwd === $hash_pwd_db) {
                    $loggato = true;
                } else {
                    $_SESSION['message'] = "Cookie errato";
                    $stmt->close();
                    $conn->close();
                    include_once "./logout.php";
                }
            } else {
                $_SESSION['message'] = "Cookie errato";
                $stmt->close();
                $conn->close();
                include_once "./logout.php";
            }
        }
        $stmt->close();
        $conn->close();
    }
    return $loggato;
}

/**
 * Controlla se l'utente abbia i permessi di admin in base
 * ai cookie che possiede
 *
 * @return bool se l'utente è un admin
 */
function controllaSeAdmin()
{
    $email = $_COOKIE['user'];

    $conn = connectToDatabase();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT admin FROM utenti WHERE email = ?");
    $stmt->bind_param("s", $email);
    $admin = false;
    if ($stmt->execute()) {
        if ($stmt->store_result() && $stmt->num_rows > 0) {
            $stmt->bind_result($admin);
            $stmt->fetch();
        } else {
            $_SESSION['message'] = "1 Nuh uh, 0 cookie vulnerability";
            $conn->close();
            $stmt->close();
            include_once "./logout.php";
        }
    }
    $conn->close();
    $stmt->close();
    return $admin;
}
