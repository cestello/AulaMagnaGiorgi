<?php
/**
 * Esegue l'inserimento nella tabella strumentazioni
 *
 * @param number $ID id dell'evento appena prenotato
 * @param array $row contiene i dati per la prenotazione
 */
function inserisciStrumentazioni($ID, $row) {
    
    $conn = connectToDatabase();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO strumentazioni(ID, pc_personale, attacco_hdmi, microfono, adattatore_apple, 
        live, rete, proiettore, mixer, vga, cavi_audio)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiiiiiiiii", $ID, $row["pc_personale"], $row["attacco_hdmi"], $row["microfono"], $row["adattatore_apple"], $row["live"], $row["rete"], 
                        $row["proiettore"], $row["mixer"], $row["vga"], $row["cavi_audio"]);

    if (!$stmt->execute()) {
        $_SESSION['message'] = "Errore non previsto nella strumentazione";
    }
}
/**
 * Esegue la prenotazione vera e propria
 *
 * @param array $row contiene i dati per la prenotazione
 */
    function prenotaEvento($row)
    {
        $conn = connectToDatabase();
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO eventi(titolo, data, ora_inizio, ora_fine, descrizione, email, docente_referente, posti)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssi", $row["titolo"], $row["data"], $row["ora_inizio"], $row["ora_fine"], $row["descrizione"], $row["email"],
                            $row["docente_referente"], $row["posti"]);

        if (!$stmt->execute()) {
            $_SESSION['message'] = "Errore non previsto nella prenotazione";
            return;
        }
        $ID = $stmt->insert_id;
        if($ID) {
            inserisciStrumentazioni($ID, $row);
        } else {
            die("Query failed: " . $ID);
        }

        $stmt->close();
        $conn->close();

        header("Location: " . generaLinkRisorsa());
        die();
    }

/**
 * Controlla se esiste già un evento che si sovrappone con quello corrente.
 * Inoltre, restituisce i messaggi di errore in base al codice ricevuto.
 *
 * @param array $row contiene i dati per la prenotazione
 */
function eseguiPrenotazione($row)
{
    $status_code = inputIsValid($row["data"], $row["ora_inizio"], $row["ora_fine"], $row["titolo"]);
    if (checkEventoEsistente($row["data"], $row["ora_inizio"], $row["ora_fine"])) {
        if ($status_code === 0) {
            prenotaEvento($row);
        } elseif ($status_code === 1) {
            $_SESSION['message'] = "Anno non valido";
        } elseif ($status_code === 2) {
            $_SESSION['message'] = "Mese non valido";
        } elseif ($status_code === 3) {
            $_SESSION['message'] = "Giorno non valido";
        } elseif ($status_code === 4) {
            $_SESSION['message'] = "Ora d'inizio non valida";
        } elseif ($status_code === 5) {
            $_SESSION['message'] = "Ora di fine non valida";
        } elseif ($status_code === 6) {
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
function convertiOrario($orario)
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
    $row = array(
                "anno" => $_POST["year"],
                "mese" => (intval($_POST["month"]) + 1),
                "giorno" => $_POST["day"],
                "data" => completaData($_POST["year"] . "-" . (intval($_POST["month"]) + 1) . "-" . $_POST["day"]),
                "ora_inizio" => convertiOrario($_POST["from"]),
                "ora_fine" => convertiOrario($_POST["to"]),
                "docente_referente" => $_POST["docente_referente"],
                "posti" => intval($_POST["posti"]),
                "titolo" => $_POST["titolo"],
                "descrizione" => $_POST["descrizione"],
                "pc_personale" => $_POST["pc_personale"] === 'on',
                "attacco_hdmi" => $_POST["attacco_hdmi"] === 'on',
                "microfono" => $_POST["microfono"] === 'on',
                "adattatore_apple" => $_POST["adattatore_apple"] === 'on',
                "live" => $_POST["live"] === 'on',
                "rete" => $_POST["rete"] === 'on',
                "proiettore" => $_POST["proiettore"] === 'on',
                "mixer" => $_POST["mixer"] === 'on',
                "vga" => $_POST["vga"] === 'on',
                "cavi_audio" => $_POST["cavi_audio"] === 'on',
                "email" => $_COOKIE['user']
            );

    if (convalidaData($row["data"])) {
        if (controlloDataMaggiore($row["data"]) && controllaSeLoggato()) {
            eseguiPrenotazione($row);
        } else {
            $_SESSION['message'] = "Data " . $row["data"] . " non prenotabile";
        }
    } else {
        $_SESSION['message'] = "Data inserita non valida";
    }
}