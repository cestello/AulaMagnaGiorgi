<?php
$nome = "";
$cognome = "";
$email = "";

function genera_utente()
{
    $conn = connect_to_database();
    $email = $_COOKIE["user"];
    $nome = "";
    $cognome = "";
    $sql_query = "SELECT * FROM utenti WHERE email = '" . $email . "';";
    $query_answer = $conn->query($sql_query);
    if ($query_answer === FALSE) {
        $_SESSION['message'] = "Errore nel collegamento";
    } else {
        $row = $query_answer->fetch_assoc();
        $nome = $row["nome"];
        $cognome = $row["cognome"];
    }
    $conn->close();
    return array($email, $nome, $cognome);
}

function genera_eventi()
{
    $conn = connect_to_database();
    $email = $_COOKIE["user"];
    $sql_query = "SELECT * FROM eventi WHERE email = '" . $email . "';";
    $records = array();
    $query_answer = $conn->query($sql_query);
    if ($query_answer === FALSE) {
        $_SESSION['message'] = "Errore nel collegamento";
    } else {
        while ($row = $query_answer->fetch_assoc()) {
            $records[] = $row;
        }
    }
    $conn->close();
    return $records;
}
