<?php

/**
 * Controlla se l'utente è loggato o meno basandosi sui cookie
 * di sessione
 * 
 * @return bool se l'utente è loggato
 */
function check()
{
    if (isset($_COOKIE['user']) && isset($_COOKIE['pass'])) {
        $email = $_COOKIE['user'];
        $password = $_COOKIE['pass'];
        $conn = connect_to_database();
        $sql_query = "SELECT password FROM utenti WHERE email = '" . $email . "';";
        $query_answer = $conn->query($sql_query);
        if ($query_answer === false || $query_answer->num_rows === 0) {
            $_SESSION['message'] = "1 Nuh uh, 0 cookie vulnerability";
            include("./logout.php");
            $conn->close();
        } else {
            $row = $query_answer->fetch_assoc();
            $db_password = $row["password"];
            if ($password === $db_password) {
                $conn->close();
                return true;
            } else {
                $_SESSION['message'] = "2 Nuh uh, 0 cookie vulnerability";
                include("./logout.php");
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
function check_admin()
{
    $email = $_COOKIE['user'];
    $conn = connect_to_database();
    $sql_query = "SELECT admin FROM utenti WHERE email = '" . $email . "';";
    $query_answer = $conn->query($sql_query);
    if ($query_answer === false || $query_answer->num_rows === 0) {
        $_SESSION['message'] = "1 Nuh uh, 0 cookie vulnerability";
        include("./logout.php");
        $conn->close();
    } else {
        $row = $query_answer->fetch_assoc();
        $admin = $row["admin"];
        return $admin;
    }
    return false;
}