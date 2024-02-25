<?php

/**
 * Controlla se l'utente è loggato o meno basandosi sui cookie
 * di sessione
 *
 * @return bool se l'utente è loggato
 */
function controllaSeLoggato()
{
    if (isset($_COOKIE['user']) && isset($_COOKIE['pass'])) {
        $email = $_COOKIE['user'];
        $password = $_COOKIE['pass'];
        $conn = connectToDatabase();
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql_query = "SELECT password FROM utenti WHERE email = '" . $email . "';";
        $query_answer = $conn->query($sql_query);
        if ($query_answer === false || $query_answer->num_rows === 0) {
            $_SESSION['message'] = "1 Nuh uh, 0 cookie vulnerability";
            include_once "./logout.php";
            $conn->close();
        } else {
            $row = $query_answer->fetch_assoc();
            $db_password = $row["password"];
            if ($password === $db_password) {
                $conn->close();
                return true;
            } else {
                $_SESSION['message'] = "2 Nuh uh, 0 cookie vulnerability";
                include_once "./logout.php";
                $conn->close();
            }
        }
    }
    return false;
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

    $sql_query = "SELECT admin FROM utenti WHERE email = '" . $email . "';";
    $query_answer = $conn->query($sql_query);
    if ($query_answer === false || $query_answer->num_rows === 0) {
        $_SESSION['message'] = "1 Nuh uh, 0 cookie vulnerability";
        include_once "./logout.php";
        $conn->close();
    } else {
        $row = $query_answer->fetch_assoc();
        return $row["admin"];
    }
    return false;
}
