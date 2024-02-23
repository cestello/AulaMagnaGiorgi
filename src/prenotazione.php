<?php

/**
 * Esegue la prenotazione vera e propria
 * 
 * @param string $titolo dell'evento
 * @param string $data in cui avrà luogo l'evento
 * @param string $ora_inizio ora di inizio
 * @param string $ora_fine ora di fine
 * @param string $descrizione dell'evento
 * @param string $email della persona che sta prenotando
 */
function prenota_evento($titolo, $data, $ora_inizio, $ora_fine, $descrizione, $email)
{
    $conn = connect_to_database();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $sql_query = "INSERT INTO eventi(titolo, data, ora_inizio, ora_fine, descrizione, email)
                    VALUES('" . $titolo . "', DATE '" . $data . "','" . $ora_inizio . "', '" . $ora_fine . "', '"
            . $descrizione . "', (SELECT email FROM utenti WHERE email='" . $email . "'));";
        $query_answer = $conn->query($sql_query);
        if ($query_answer === false) {
            $_SESSION['message'] = "Errore non previsto nella prenotazione";
        }
        $conn->close();
        header("Location: " . MAINURL . "index.php");
        die();
    }
}

/**
 * Controlla se esiste già un evento che si sovrappone con quello corrente.
 * Inoltre, restituisce i messaggi di errore in base al codice ricevuto.
 * 
 * @param string $anno in cui ha luogo l'evento
 * @param string $mese in cui ha luogo l'evento
 * @param string $giorno in cui ha luogo l'evento
 * @param string $ora_inizio ora di inizio
 * @param string $ora_fine ora di fine
 * @param string $titolo dell'evento
 * @param string $descrizione dell'evento
 * @param string $email del richiedente
 */
function eseguiPrenotazione($anno, $mese, $giorno, $ora_inizio, $ora_fine, $titolo, $descrizione, $email)
{
    $data = $anno . "-" . $mese . "-" . $giorno;
    $status_code = input_is_valid($anno, $mese, $giorno, $ora_inizio, $ora_fine, $titolo);
    if (check_evento_esistente($data, $ora_inizio, $ora_fine)) {
        if ($status_code === 0) {
            // $_SESSION['message'] = "Ok";
            prenota_evento($titolo, $data, $ora_inizio, $ora_fine, $descrizione, $email);
        } else if ($status_code === 1) {
            $_SESSION['message'] = "Anno non valido";
        } else if ($status_code === 2) {
            $_SESSION['message'] = "Mese non valido";
        } else if ($status_code === 3) {
            $_SESSION['message'] = "Giorno non valido";
        } else if ($status_code === 4) {
            $_SESSION['message'] = "Ora d'inizio non valida";
        } else if ($status_code === 5) {
            $_SESSION['message'] = "Ora di fine non valida";
        } else if ($status_code === 6) {
            $_SESSION['message'] = "Titolo non valido";
        } else {
            $_SESSION['message'] = "Giorno selezionato non disponibile";
        }
    }
}

/**
 * Converte l'indice ricevuto in input in uno degli orari consentiti
 * 
 * @param number $orario sottoforma di indice [0, 12)
 * @return string orario sottoforma di stringa
 */
function converti_orario($orario)
{
    $orari = array(
        "8:00",
        "8:30",
        "9:00",
        "9:30",
        "10:00",
        "10:30",
        "11:00",
        "11:30",
        "12:00",
        "12:30",
        "13:00",
        "13:30",
        "14:00"
    );
    return $orari[$orario];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $anno = $_POST["year"];
    $mese = (intval($_POST["month"]) + 1);
    $giorno = $_POST["day"];
    $ora_inizio = converti_orario($_POST["from"]);
    $ora_fine = converti_orario($_POST["to"]);
    $titolo = $_POST["titolo"];
    $descrizione = $_POST["descrizione"];
    $email = $_COOKIE['user'];

    if ($year !== date("Y")) {
        eseguiPrenotazione($anno, $mese, $giorno, $ora_inizio, $ora_fine, $titolo, $descrizione, $email);
    } else if ($giorno >= date("l") && $mese >= date("m")) {
        eseguiPrenotazione($anno, $mese, $giorno, $ora_inizio, $ora_fine, $titolo, $descrizione, $email);
    } else {
        $_SESSION['message'] = "Non &egrave; possibile prenotare in un giorno precedente a quello corrente.";
    }
    echo $_SESSION['messaggio'];
}
