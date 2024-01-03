<?php
$conn = connect_to_database();
$email = $_COOKIE["user"];
$sql_query = "SELECT * FROM utenti WHERE email = '" . $email . "';";
$nome = ""; $cognome = ""; $email = "";
$query_answer = $conn->query($sql_query);
if ($query_answer === FALSE) {
    $_SESSION['message'] = "Errore nel collegamento";
    $conn->close();
} else {
    $row = $query_answer->fetch_assoc();
    $_SESSION['message'] = "Ok";
    $nome = $row["nome"];
    $cognome = $row["cognome"];
    $email = $row["email"];
}
$conn->close();
?>