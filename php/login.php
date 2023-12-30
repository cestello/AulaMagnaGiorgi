<?php
/*
    LOGIN
    Email
    Pwd
*/

include('../util/utils.php');

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $email = $_POST["username"];
    $password = $_POST["password"];
    if (is_used($email))
    {
        $conn = connect_to_database();
        $sql_query = "SELECT email FROM utenti WHERE email = '". $email . "';";
        $query_answer = $conn->query($sql_query);
        if($query_answer === FALSE) {
        } else {
            $row = $query_answer->fetch_assoc();
            $db_password = $row["email"];
            if($db_password == $password) {
                echo("Accesso effettuato con successo");
            } else {
                echo("Password errata");
            }
        }
        $conn->close();
    }
    else
    {
        echo("Account inesistente");
    }
}
