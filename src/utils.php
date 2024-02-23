<?php

/**
 * Link di base all'index
 */
const MAINURL = "http://138.41.20.100/~rizzello2400/";

/**
 * Permette di connettersi al database ritornando un oggetto
 * di tipo classe mysqli
 * 
 * @return mysqli connessione
 */
function connect_to_database()
{
    $servername = "mysql.giorgi.edu";
    $username = "5aiu16";
    $password = "utenti";
    $dbname = "5ai23rizzello";
    return new mysqli($servername, $username, $password, $dbname);;
}

/**
 * Controlla se l'email passata viene già utilizzata
 * da un account
 * 
 * @param string $email dell'utente
 * @param mysqli $conn connessione
 * @return bool se la mail viene già utilizzata
 */
function is_mail_used($email, $conn)
{
    $sql_query = "SELECT email FROM utenti WHERE email = '" . $email . "';";

    $query_answer = $conn->query($sql_query);
    if ($query_answer->num_rows > 0) {
        $conn->close();
        return true;
    }

    return false;
}

/**
 * Controlla se la password è corretta in termini di:
 * lunghezza, espressione regolare e se la password e 
 * la conferma della password corrispondono
 * 
 * @param string $password dell'utente
 * @param string $confermaPassword conferma della password
 * @return int codice di errore
 */
function is_password_valid($password, $confermaPassword)
{
    $lunghezza = strlen($password);
    if ($lunghezza < 8 || $lunghezza > 32) {
        return 1;
    }

    if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[\d])(?=.*[#?!@$%^&*-]).{8,}$/', $password)) {
        return 2;
    }

    if ($confermaPassword != $password) {
        return 3;
    }
    return 0;
}

/**
 * Controlla se l'email è valida in termini di:
 * lunghezza ed espressione regolare
 * 
 * @param string $email dell'utente
 * @return int codice di errore
 */
function is_mail_valid($email)
{
    $lunghezza = strlen($email);
    if ($lunghezza < 7 || $lunghezza > 128) {
        return 1;
    }

    if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
        return 2;
    }

    return 0;
}

/**
 * Controlla se la data fornita sia maggiore o uguale alla data
 * odierna
 * 
 * @param string $data 
 * @return bool se la data è maggiore o uguale a quella giornaliera
 */
function checkDataCorrente($data)
{
    $differenza = date_diff(date_create(date("Y-m-d")), date_create($data));
    $giorni = intval($differenza->format("%R%a"));
    return $giorni >= 0;
}

/**
 * Controlla che l'input abbia valori necessari validi
 * 
 * @param int $anno dell'evento
 * @param int $mese dell'evento
 * @param int $giorno dell'evento
 * @param string $ora_inizio ora di inizio
 * @param string $ora_fine ora di fine
 * @param string $titolo dell'evento
 * @return int codice di errore
 */
function input_is_valid($anno, $mese, $giorno, $ora_inizio, $ora_fine, $titolo)
{
    if (!isset($anno)) {
        return 1;
    }

    if (!isset($mese)) {
        return 2;
    }

    if (!isset($giorno)) {
        return 3;
    }

    if (!isset($ora_inizio)) {
        return 4;
    }

    if (!isset($ora_fine)) {
        return 5;
    }

    if (!isset($titolo)) {
        return 6;
    }

    if (!checkDataCorrente($anno . "-" . $mese . "-" . $giorno)) {
        return 7;
    }

    return 0;
}

/**
 * Controlla se gli orari di due eventi si sovrappongono
 * 
 * @param string $ora_inizio_0 ora di inizio del primo evento
 * @param string $ora_fine_0 ora di fine del primo evento
 * @param string $ora_inizio_1 ora di inizio del secondo evento
 * @param string $ora_fine_1 ora di fine del secondo evento
 * @return bool se gli eventi non si sovrappongono
 */
function check_ora($ora_inizio_0, $ora_fine_0, $ora_inizio_1, $ora_fine_1)
{
    $ora_inizio_0_int = intval(str_replace(":", "", $ora_inizio_0));
    $ora_fine_0_int = intval(str_replace(":", "", $ora_fine_0));
    $ora_inizio_1_int = intval(str_replace(":", "", $ora_inizio_1));
    $ora_fine_1_int = intval(str_replace(":", "", $ora_fine_1));

    if ($ora_inizio_0_int >= $ora_inizio_1_int && $ora_inizio_0_int < $ora_fine_1_int) {
        return false;
    }

    if ($ora_fine_0_int > $ora_inizio_1_int && $ora_fine_0_int <= $ora_fine_1_int) {
        return false;
    }
    return true;
}

/**
 * Controlla se esistono eventi che si sovrappongono a quello che si
 * vuole inserire
 * 
 * @param string $data del giorno da prenotare
 * @param string $ora_inizio ora di inizio
 * @param string $ora_fine ora di fine
 * @param ?string $tipo di fine della funzione
 */
function check_evento_esistente($data, $ora_inizio, $ora_fine, $tipo = false)
{
    $conn = connect_to_database();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $sql_query = "SELECT * FROM eventi WHERE data='" . $data . "' AND stato=1;";
        $query_answer = $conn->query($sql_query);
        if ($query_answer === false) {
            $_SESSION['message'] = "Errore non previsto nella registrazione";
            $conn->close();
            return false;
        }

        if ($query_answer->num_rows <= 0) {
            $conn->close();
            return true;
        }

        while ($row = $query_answer->fetch_assoc()) {
            $row["ora_inizio"] = substr($row["ora_inizio"], 0, -3);
            $row["ora_fine"] = substr($row["ora_fine"], 0, -3);
            if (!check_ora($row["ora_inizio"], $row["ora_fine"], $ora_inizio, $ora_fine)) {
                $_SESSION['message'] = "Orario gi&agrave; prenotato";
                $conn->close();
                if ($tipo) {
                    return $row["ID"];
                }
                return false;
            }
        }
        $conn->close();
        return true;
    }
}

/**
 * Permette di ottenere data e ora di inizio e fine di un evento
 * a partire dal suo id
 * 
 * @param int $ID dell'evento
 * @return array record contenente data e orari dell'evento
 */
function getDataByID($ID)
{
    $conn = connect_to_database();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $sql_query = "SELECT * FROM eventi WHERE ID=" . $ID . ";";
        $query_answer = $conn->query($sql_query);
        if ($query_answer === false || $query_answer->num_rows <= 0) {
            $_SESSION['message'] = "Errore non previsto nella query";
            $conn->close();
            return array(-1, -1, -1);
        }
        if ($query_answer->num_rows <= 0) {
            $conn->close();
            return array(0, 0, 0);
        }
        $answer = $query_answer->fetch_assoc();
        return array($answer["data"], $answer["ora_inizio"], $answer["ora_fine"]);
    }
}

/**
 * Dispone i pulsanti per le categorie di stati degli eventi: non visionato,
 * accettato, rifiutato, annullato, scaduto [0, 4]
 * 
 * @param int $stato dell'evento
 * @param int $ID dell'evento
 */
function setup_tipo_prenotazioni($stato, $ID)
{
    if ($stato === 0) {
        echo ('<input type="button" name="accetta" value="accetta" id="' .
            $ID . '" onClick="gestisci_richiesta(this.id, this.name)">');
        echo ('<input type="button" name="rifiuta" value="rifiuta" id="' .
            $ID . '" onClick="gestisci_richiesta(this.id, this.name)">');
    } else if ($stato === 1) {
        echo ('<input type="button" name="annulla" value="annulla" id="' .
            $ID . '" onClick="gestisci_richiesta(this.id, this.name)">');
    } else if ($stato === 2) {
        echo ('<input type="button" name="accetta" value="accetta" id="' .
            $ID . '" onClick="gestisci_richiesta(this.id, this.name)">');
    } else if ($stato === 3) {
        echo ('<input type="button" name="accetta" value="accetta" id="' .
            $ID . '" onClick="gestisci_richiesta(this.id, this.name)">');
    }
}

/**
 * Visualizza l'elenco di prenotazioni in base allo stato selezionato
 * 
 * @param int $stato selezionato
 */
function setup_prenotazioni($stato)
{
    $conn = connect_to_database();
    $sql_query = "SELECT * FROM eventi WHERE stato = " . $stato . ";";
    $query_answer = $conn->query($sql_query);
    if ($query_answer === false) {
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
                echo ('<div class="events-container ' . $row["ID"] . '">');
                echo ("Nome: " . $row["titolo"] . "<br>" . "Richiesto da: " . $row["email"] . "<br>" .
                    "Data: " . $row["data"] . " Dalle ore: " . $row["ora_inizio"] . " alle " .
                    $row["ora_fine"] . "<br>");
                if (isset($row["descrizione"]) && $row["descrizione"] !== "") {
                    echo ("Descrizione: " . $row["descrizione"] . "<br>");
                }
                echo ("<br>");

                setup_tipo_prenotazioni($stato, $row["ID"]);

                echo ("</div><br>");
            }
        }
    }
    $conn->close();
}
