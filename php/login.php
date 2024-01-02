<?php
/*
    LOGIN
    Email
    Pwd
*/

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $email = $_POST["username"];
    $password = $_POST["password"];
    if (is_used($email))
    {
        $conn = connect_to_database();
        $sql_query = "SELECT password FROM utenti WHERE email = '". $email . "';";
        $query_answer = $conn->query($sql_query);
        if($query_answer === FALSE) {
            $_SESSION['message'] = "Errore nel Login";
            $conn->close();
        } else {
            $row = $query_answer->fetch_assoc();
            $db_password = $row["password"];
            if(hash('sha256', $password) === $db_password) {
                $_SESSION['message'] = "Accesso effettuato con successo";
                setcookie("user", $email, time() + 86400 * 30, "/");
                setcookie("pass", $db_password, time() + 86400 * 30, "/");
                $conn->close();
                header("Location: http://138.41.20.100/~rizzello2400/index.php");
                die();
            } else {                
                $_SESSION['message'] = "Password errata";
                $conn->close();
            }
        }
    }
    else
    {
        $_SESSION['message'] = "Account inesistente";
    }
}   