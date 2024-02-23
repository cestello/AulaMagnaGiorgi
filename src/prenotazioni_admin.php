<?php

/**
 * 
 */
function update_stato($value, $ID)
{
    $conn = connect_to_database();
    $sql_query = "UPDATE eventi SET stato = " . $value . " WHERE ID = " . $ID . ";";
    $query_answer = $conn->query($sql_query);
    if ($query_answer === false) {
        $_SESSION['message'] = "Errore nel collegamento";
        $conn->close();
        return;
    }
    $conn->close();
}

/**
 * 
 */
function set_scaduto($ID)
{
    //TODO
}

/**
 * 
 */
function gestisci_prenotazione($value, $ID)
{
    if ($value === 1) {
        $tmp = getDataByID($ID);
        $tmp[1] = substr($tmp[1], 0, -3);
        $tmp[2] = substr($tmp[2], 0, -3); //ok
        if (!check_evento_esistente($tmp[0], $tmp[1], $tmp[2])) {
            $_SESSION["message"] = "Giorno gia' prenotato";
        } else {
            update_stato($value, $ID);
        }
    } else {
        update_stato($value, $ID);
    }
}

/**
 * 
 */
function gestisci_input($ID, $tipo)
{
    if ($tipo === "accetta") {
        gestisci_prenotazione(1, $ID);
    } else if ($tipo === "rifiuta") {
        gestisci_prenotazione(2, $ID);
    } else if ($tipo === "annulla") {
        gestisci_prenotazione(3, $ID);
    } else {
        $_SESSION["message"] = "I valori della richiesta GET sono settati male";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && sizeof($_GET) > 0) {
    if (isset($_GET["ID"]) && isset($_GET["name"])) {
        gestisci_input($_REQUEST["ID"], $_REQUEST["name"]);
    }
}