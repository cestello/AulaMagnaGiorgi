<?php
$conn = connect_to_database();
$email = $_COOKIE["user"];
$sql_query = "SELECT * FROM eventi WHERE email = '" . $email . "';";
$print = "";
$query_answer = $conn->query($sql_query);
if ($query_answer === FALSE) {
    $_SESSION['message'] = "Errore nel collegamento";
    $conn->close();
} else {
    $records= array();
    while($row = $query_answer->fetch_assoc()) {
        $records[] = $row;
    }

    foreach($records as $row) {
        //TODO crea tabella da in una variabile e fare echo
        echo($row["nome"]);
    }
}
$conn->close();
?>