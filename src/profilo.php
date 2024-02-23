<?php
$nome = "";
$cognome = "";
$email = "";

/**
 * Raccoglie le informazioni dell'utente e ne genera il profilo personale
 * 
 * @return array dati dell'utente
 */
function genera_utente()
{
    $conn = connect_to_database();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_COOKIE["user"];
    $nome = "";
    $cognome = "";

    $sql_query = "SELECT * FROM utenti WHERE email = '" . $email . "';";
    $query_answer = $conn->query($sql_query);
    if ($query_answer === false) {
        $_SESSION['message'] = "Errore nel collegamento";
    } else {
        $row = $query_answer->fetch_assoc();
        $nome = $row["nome"];
        $cognome = $row["cognome"];
    }

    $conn->close();
    return array($email, $nome, $cognome);
}

/**
 * Raccoglie gli eventi legati all'utente per disporli sul proprio profilo
 * 
 * @return array record di eventi
 */
function genera_eventi()
{
    $conn = connect_to_database();
    $email = $_COOKIE["user"];
    $sql_query = "SELECT * FROM eventi WHERE email = '" . $email . "';";
    $records = array();
    $query_answer = $conn->query($sql_query);
    if ($query_answer === false) {
        $_SESSION['message'] = "Errore nel collegamento";
    } else {
        while ($row = $query_answer->fetch_assoc()) {
            $records[] = $row;
        }
    }
    $conn->close();
    return $records;
}
