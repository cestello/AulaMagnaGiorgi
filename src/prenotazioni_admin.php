<?php

function gestisci_prenotazione($value, $ID)
{
    $conn = connect_to_database();
    $sql_query = "UPDATE eventi SET stato = " . $value . " WHERE ID = " . $ID . ";";
    $query_answer = $conn->query($sql_query);
    if ($query_answer === FALSE) {
        $_SESSION['message'] = "Errore nel collegamento";
        $conn->close();
    }
    $conn->close();
}

function gestisci_input($ID, $tipo)
{
    if ($tipo == "accetta") {
        gestisci_prenotazione(1, $ID);
    } else if ($tipo == "rifiuta") {
        gestisci_prenotazione(2, $ID);
    } else {
        $_SESSION["message"] = "I valori della richiesta GET sono settati male";
    }
}

function setup_prenotazioni()
{
    $conn = connect_to_database();
    $sql_query = "SELECT * FROM eventi WHERE stato = 0;";
    $query_answer = $conn->query($sql_query);
    if ($query_answer === FALSE) {
        $_SESSION['message'] = "Errore nel collegamento";
        $conn->close();
    } else {
        $records = array();
        while ($row = $query_answer->fetch_assoc()) {
            $records[] = $row;
        }
        if (sizeof($records) <= 0) {
            echo ("Nessuna nuova prenotazione");
        } else {
            foreach ($records as $row) {
                //TODO crea tabella da in una variabile e fare echo
                echo ('<div class="events-container ' . $row["ID"] . '">');
                echo ("Nome: " . $row["nome"] . "<br>" . "Richiesto da: " . $row["email"] . "<br>" . "Data: " . $row["data"] . "<br>");
                echo ("<br>");

                // Utilizza l'ID dell'evento come valore del pulsante
                echo ('<input type="button" name="accetta" value="accetta" id="' . $row["ID"] . '" onClick="gestisci_richiesta(this.id, this.name)">');
                echo ('<input type="button" name="rifiuta" value="rifiuta" id="' . $row["ID"] . '" onClick="gestisci_richiesta(this.id, this.name)">');
                echo ("</div><br>");
            }
        }
    }
    $conn->close();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && sizeof($_GET) > 0) {
    if (isset($_GET["ID"]) && isset($_GET["name"])) {
        gestisci_input($_REQUEST["ID"], $_REQUEST["name"]);
    } else {
        echo ("errore");
    }
}