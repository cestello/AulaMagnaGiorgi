<?php

include_once "../src/utils.php";

/**
 * Effettua l'aggiornamento dello stato
 *
 * @param int $valore dello stato
 * @param int $id dell'evento
 */
function aggiornaStato($stato, $id)
{
    $conn = connectToDatabase();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("UPDATE eventi SET stato = ? WHERE ID = ?");
    $stmt->bind_param("ii", $stato, $id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Errore non previsto durante l&apos;aggiornamento dello stato";
    }

    $stmt->close();
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
        $tmp = ottieniDataDaID($id);
        $tmp[1] = substr($tmp[1], 0, -3); //leva gli ultimi 3 caratteri
        $tmp[2] = substr($tmp[2], 0, -3);
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
    if (controllaSeLoggato() && controllaSeAdmin() && isset($_GET["ID"]) && isset($_GET["name"])) {
        gestisciInput($_REQUEST["ID"], $_REQUEST["name"]);
    }
}
