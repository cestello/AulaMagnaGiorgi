<?php

/**
 * Effettua l'aggiornamento dello stato
 *
 * @param int $valore dello stato
 * @param int $id dell'evento
 */
function aggiornaStato($valore, $id)
{
    $conn = connectToDatabase();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $sql_query = "UPDATE eventi SET stato = " . $valore . " WHERE ID = " . $id . ";";
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
function impostaScaduto($id)
{
    //TODO
}

/**
 * Gestisce una prenotazione
 *
 * @param int $valore dello stato
 * @param int $id dell'evento
 */
function gestisciPrenotazione($valore, $id)
{
    if ($valore === 1) {
        $tmp = getDataByID($id);
        $tmp[1] = substr($tmp[1], 0, -3);
        $tmp[2] = substr($tmp[2], 0, -3); //ok
        if (!checkEventoEsistente($tmp[0], $tmp[1], $tmp[2])) {
            $_SESSION["message"] = "Giorno gia' prenotato";
        } else {
            aggiornaStato($valore, $id);
        }
    } else {
        aggiornaStato($valore, $id);
    }
}

/**
 * Gestisce l'input
 *
 * @param int $id dell'evento
 * @param string $tipo di azione
 */
function gestisciInput($id, $tipo)
{
    if ($tipo === "accetta") {
        gestisciPrenotazione(1, $id);
    } elseif ($tipo === "rifiuta") {
        gestisciPrenotazione(2, $id);
    } elseif ($tipo === "annulla") {
        gestisciPrenotazione(3, $id);
    } else {
        $_SESSION["message"] = "I valori della richiesta GET sono settati male";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET)) {
    if (isset($_GET["ID"]) && isset($_GET["name"])) {
        gestisciInput($_REQUEST["ID"], $_REQUEST["name"]);
    }
}
