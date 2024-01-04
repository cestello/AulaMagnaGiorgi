<?php
$conn = connect_to_database();
$email = $_COOKIE["user"];
$sql_query = "SELECT * FROM eventi WHERE stato = 0;";
$print = "";
$query_answer = $conn->query($sql_query);
if ($query_answer === FALSE) {
    $_SESSION['message'] = "Errore nel collegamento";
    $conn->close();
} else {
    $records = array();
    while ($row = $query_answer->fetch_assoc()) {
        $records[] = $row;
    }
    foreach ($records as $row) {
        //TODO crea tabella da in una variabile e fare echo
        echo ("Nome: " . $row["nome"] . "<br>" . "Richiesto da: " . $row["email"] . "<br>" . "Data: " . $row["data"] . "<br>");
        echo ("<br>");
    }
}
$conn->close();