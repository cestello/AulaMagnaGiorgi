<?php

/**
 * Link di base all'index
 */
const MAINURL = "http://138.41.20.100/~rizzello2400/";

/**
 * Lunghezza minima della password
 */
const MIN_LUNGHEZZA_PWD = 8;

/**
 * Lunghezza massima della password
 */
const MAX_LUNGHEZZA_PWD = 64;

/**
 * Minima lunghezza dell'email
 */
const MIN_LUNGHEZZA_EMAIL = 7;

/**
 * Massima lunghezza dell'email
 */
const MAX_LUNGHEZZA_EMAIL = 128;

/**
 * Genera il codice HTML per il collegamento dei fogli di stile
 *
 * @param string nome del file CSS SENZA l'estensione (si assume che si trovi in '/public/css/')
 * @return string codice HTML del tag <link \>
 */
function collegaCSS($nomeFile = "style")
{
    return '<link rel="stylesheet" href="' . generaLinkRisorsa("public/css/" . $nomeFile . ".css") . '" type="text/css">';
}

/**
 * Ritorna un link ad una risorsa il cui percorso
 * è concatenato alla root (src/utils.php -> MAINURL)
 *
 * @param string $percorsoRisorsa per la quale generare il link
 * @return string MAINURL concatenato al parametro
 */
function generaLinkRisorsa($percorsoRisorsa = "")
{
    return MAINURL . $percorsoRisorsa;
}

/**
 * Permette di connettersi al database ritornando un oggetto
 * di tipo classe mysqli
 *
 * @return mysqli connessione
 */
function connectToDatabase()
{
    $servername = "mysql.giorgi.edu"; // NON DIVULGARE
    $username = "5aiu16";
    $password = "utenti";
    $dbname = "5ai23rizzello";
    return new mysqli($servername, $username, $password, $dbname);
}

function logout()
{
    setcookie('email', '', -1, '/');
    setcookie('session', '', -1, '/');

    header("Location: " . MAINURL);
    die();
}

/**
 * Controlla se l'email passata viene già utilizzata
 * da un account
 *
 * @param string $email dell'utente
 * @param mysqli $conn connessione
 * @return bool se la mail viene già utilizzata
 */
function isMailUsed($email)
{
    $conn = connectToDatabase();
    $stmt = $conn->prepare("SELECT email FROM utenti WHERE email = ?");
    $stmt->bind_param("s", $email);
    $isUsed = true;
    if ($stmt->execute()) {
        $stmt->store_result();
        $isUsed = $stmt->num_rows > 0;
    } else {
        $_SESSION['message'] = "Errore non previsto durante il controllo dell&apos;email";
    }

    $stmt->close();
    $conn->close();
    return $isUsed;
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
function isPasswordValid($password, $confermaPassword)
{
    $lunghezza = strlen($password);
    if ($lunghezza < MIN_LUNGHEZZA_PWD || $lunghezza > MAX_LUNGHEZZA_PWD) {
        return 1;
    }

    if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[\d])(?=.*[#?!@$%^&*-]).{8,}$/', $password)) {
        return 2;
    }

    if ($confermaPassword !== $password) {
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
function isMailValid($email)
{
    $lunghezza = strlen($email);
    if ($lunghezza < MIN_LUNGHEZZA_EMAIL || $lunghezza > MAX_LUNGHEZZA_EMAIL) {
        return 1;
    }

    if (!preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
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
function controlloDataCorrente($data)
{
    $differenza = date_diff(date_create(date("Y-m-d")), date_create($data));
    $giorni = intval($differenza->format("%R%a"));
    return $giorni >= 0;
}

/**
 * Controlla se la data fornita sia maggiore o uguale alla data
 * odierna
 *
 * @param string $data
 * @return bool se la data è maggiore o uguale a quella giornaliera
 */
function controlloDataMaggiore($data)
{
    $differenza = date_diff(date_create(date("Y-m-d")), date_create($data));
    $giorni = intval($differenza->format("%R%a"));
    return $giorni > 0;
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
function inputIsValid($data, $ora_inizio, $ora_fine, $titolo)
{
    $anno = ottieniAnno($data);
    if (!isset($anno)) {
        return 1;
    }

    $mese = ottieniMese($data);
    if (!isset($mese)) {
        return 2;
    }

    $giorno = ottieniGiorno($data);
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

    if (!controlloDataCorrente($data)) {
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
function controlloOra($ora_inizio_0, $ora_fine_0, $ora_inizio_1, $ora_fine_1)
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
 * Ottieni l'anno da una stringa rappresentante una data
 * in un formato che inizi con l'anno (primi 4 caratteri)
 *
 * @param string $data data in formato stringa
 * @return string i primi 4 caratteri rappresentanti l'anno
 */
function ottieniAnno($data)
{
    return substr($data, 0, 4);
}

/**
 * Ottieni il mese da una stringa in un formato che possiede
 * il mese nel mezzo (formato necessariamente da 2 caratteri)
 *
 * @param string $data in formato stringa
 * @return string i 2 caratteri rappresentanti il mese
 */
function ottieniMese($data)
{
    return substr($data, 5, 2);
}

/**
 * Ottieni il giorno da una stringa in un formato che possiede
 * il giorno alla fine (necessariamente gli ultimi due caratteri)
 *
 * @param string $data in formato stringa
 * @return string i 2 caratteri che rappresentano il giorno
 */
function ottieniGiorno($data)
{
    return substr($data, 8, 2);
}

/**
 * Se la data fornita non è completa degli zeri prima di giorni
 * e mesi, viene completata per facilitarne manipolazioni e confronti
 *
 * @param string $data in formato stringa
 * @return string la data completa
 */
function completaData($data)
{
    $lunghezza = strlen($data);
    if ($lunghezza === 8) {
        $data = substr($data, 0, 5) . "0" . substr($data, 5, 2) . "0" . substr($data, 7, 2);
    } elseif ($lunghezza === 9) {
        // 0123456789
        // 2222-11-00
        if ($data[6] == "-") {
            $data = substr($data, 0, 5) . "0" . substr($data, 5, 4);
        } else {
            $data = substr($data, 0, 7) . "0" . substr($data, 7, 2);
        }
    } elseif ($lunghezza !== 10) {
        $data = "0000-00-00";
    }
    return $data;
}

/**
 * Controlla se esistono eventi che si sovrappongono a quello che si
 * vuole inserire
 *
 * @param string $data del giorno da prenotare
 * @param string $ora_inizio ora di inizio
 * @param string $ora_fine ora di fine
 * @param ?string $tipo di fine della funzione
 * @return bool|int
 */
function checkEventoEsistente($data, $ora_inizio, $ora_fine, $tipo = false)
{
    $conn = connectToDatabase();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $data = completaData($data);

    $stmt = $conn->prepare("SELECT ID, ora_inizio, ora_fine FROM eventi WHERE data = ? AND stato = 1");
    $stmt->bind_param("s", $data);
    if (!$stmt->execute()) {
        $_SESSION['message'] = "Errore non previsto nella registrazione";
        $stmt->close();
        $conn->close();
        return false;
    }

    $stmt->store_result();
    if ($stmt->num_rows <= 0) {
        $stmt->close();
        $conn->close();
        return true;
    }

    $stmt->bind_result($id, $ora_inizio_altro, $ora_fine_altro);
    while ($stmt->fetch()) {
        $ora_inizio_altro = substr($ora_inizio_altro, 0, -3);
        $ora_fine_altro = substr($ora_fine_altro, 0, -3);
        if (!controlloOra($ora_inizio, $ora_fine, $ora_inizio_altro, $ora_fine_altro)) {
            $_SESSION['message'] = "Orario gi&agrave; prenotato";
            $stmt->close();
            $conn->close();
            if ($tipo) {
                return $id;
            }
            return false;
        }
    }

    $stmt->close();
    $conn->close();
    return true;
}

/**
 * Controlla se una data sia valida (formato di default Y-m-d)
 *
 * @param string $data data sottoforma di stringa di 10 caratteri
 * @param string $formato formato della data (opzionale)
 * @return bool se la data è valida
 */
function convalidaData($data, $formato = 'Y-m-d')
{
    $d = DateTime::createFromFormat($formato, $data);
    return $d && ($d->format($formato) === $data);
}

/**
 * Permette di ottenere data e ora di inizio e fine di un evento
 * a partire dal suo id
 *
 * @param int $id dell'evento
 * @return array record contenente data e orari dell'evento
 */
function ottieniDataDaID($id)
{
    $conn = connectToDatabase();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT data, ora_inizio, ora_fine FROM eventi WHERE ID = ?");
    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        $_SESSION['message'] = "Errore non previsto nella query";
        $stmt->close();
        $conn->close();
        return array(-1, -1, -1);
    }

    $stmt->store_result();
    if ($stmt->num_rows <= 0) {
        $stmt->close();
        $conn->close();
        return array(0, 0, 0);
    }

    $stmt->bind_result($data, $ora_inizio, $ora_fine);
    $stmt->close();
    $conn->close();
    return array($data, $ora_inizio, $ora_fine);
}

/**
 * Genera il pulsante dati tipo (accetta, rifiuta, annulla) e
 * id (ovvero lo stato)
 *
 * @param string $tipo del pulsante
 * @param int $id dell'evento
 * @return string codice HTML del pulsante
 */
function pulsante($tipo, $id)
{
    return '<input class="button-page" type="button" name="' . $tipo . '" value="' . $tipo .
        '" id="' . $id . '" onClick="gestisci_richiesta(this.id, this.name)">';
}

/**
 * Dispone i pulsanti per le categorie di stati degli eventi: non visionato,
 * accettato, rifiutato, annullato, scaduto [0, 4]
 *
 * @param int $stato dell'evento
 * @param int $id dell'evento
 * @return string codice HTML del pulsante
 */
function setupTipoPrenotazioni($stato, $id)
{
    $pulsante = "";
    if ($stato === 0) {
        $pulsante .= pulsante("accetta", $id);
        $pulsante .= pulsante("rifiuta", $id);
    } elseif ($stato === 1) {
        $pulsante .= pulsante("annulla", $id);
    } elseif ($stato === 2) {
        $pulsante .= pulsante("accetta", $id);
    } elseif ($stato === 3) {
        $pulsante .= pulsante("accetta", $id);
    }
    return $pulsante;
}

/**
 * Visualizza l'elenco di prenotazioni in base allo stato selezionato
 *
 * @param int $stato selezionato
 */
function setupPrenotazioni($stato, $type = false)
{
    $conn = connectToDatabase();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (!$type) {
        $stmt = $conn->prepare("SELECT * FROM eventi NATURAL JOIN strumentazioni WHERE stato = ? ORDER BY data ASC, ora_inizio ASC");
    } else {
        $stmt = $conn->prepare("SELECT * FROM eventi NATURAL JOIN strumentazioni WHERE stato = ? AND data >= CURDATE()
        ORDER BY data DESC, ora_inizio ASC");
    }

    $stmt->bind_param("i", $stato);
    if (!$stmt->execute()) {
        $_SESSION['message'] = "Errore non previsto nella query";
        $stmt->close();
        $conn->close();
        return;
    }

    $stmt->store_result();
    if ($stmt->num_rows <= 0) {
        echo "Nessuna nuova prenotazione";
        $stmt->close();
        $conn->close();
        return;
    }

    $row = array(
        "id" => "0",
        "data" => "1970-01-01",
        "ora_inizio" => "08:00",
        "ora_fine" => "08:30",
        "docente_referente" => "default",
        "posti" => -1,
        "titolo" => "default",
        "descrizione" => "default",
        "email" => "default",
        "pc_personale" => 0,
        "attacco_hdmi" => 0,
        "microfono" => 0,
        "adattatore_apple" => 0,
        "live" => 0,
        "rete" => 0,
        "proiettore" => 0,
        "mixer" => 0,
        "vga" => 0,
        "cavi_audio" => 0
    );

    $stmt->bind_result(
        $row["id"],
        $row["titolo"],
        $row["data"],
        $row["ora_inizio"],
        $row["ora_fine"],
        $row["descrizione"],
        $row["email"],
        $row["stato"],
        $row["docente_referente"],
        $row["posti"],
        $row["pc_personale"],
        $row["attacco_hdmi"],
        $row["microfono"],
        $row["adattatore_apple"],
        $row["live"],
        $row["rete"],
        $row["proiettore"],
        $row["mixer"],
        $row["vga"],
        $row["cavi_audio"]
    );

    while ($stmt->fetch()) {
        foreach ($row as &$i) {
            if ($i === 0) {
                $i = "No";
            } elseif ($i === 1) {
                $i = "Si";
            }
        }

        $html = '<div class="events-container ' . $row["id"] . '">';
        $html .= "Nome: " . $row["titolo"] . "<br>";
        $html .= "Richiesto da: " . $row["email"] . "<br>";
        $html .= "Data: " . $row["data"] . "<br>";
        $html .= " Dalle ore: " . $row["ora_inizio"] . " alle " . $row["ora_fine"] . "<br>";
        $html .= "Docente referente: " . $row["docente_referente"] . "<br>";
        $html .= "Posti: " . $row["posti"] . "<br>";

        // Strumentazione
        if ($row["pc_personale"] === "Si") {
            $html .= "Pc personale: " . $row["pc_personale"] . "<br>";
        }
        if ($row["attacco_hdmi"] === "Si") {
            $html .= "Attacco HDMI: " . $row["attacco_hdmi"] . "<br>";
        }
        if ($row["microfono"] === "Si") {
            $html .= "Microfono: " . $row["microfono"] . "<br>";
        }
        if ($row["adattatore_apple"] === "Si") {
            $html .= "Adattatore Apple: " . $row["adattatore_apple"] . "<br>";
        }
        if ($row["live"] === "Si") {
            $html .= "live: " . $row["live"] . "<br>";
        }
        if ($row["rete"] === "Si") {
            $html .= "Rete: " . $row["rete"] . "<br>";
        }
        if ($row["proiettore"] === "Si") {
            $html .= "Proiettore: " . $row["proiettore"] . "<br>";
        }
        if ($row["mixer"] === "Si") {
            $html .= "Mixer: " . $row["mixer"] . "<br>";
        }
        if ($row["vga"] === "Si") {
            $html .= "Vga: " . $row["vga"] . "<br>";
        }
        if ($row["cavi_audio"] === "Si") {
            $html .= "Cavi audio: " . $row["cavi_audio"] . "<br>";
        }

        if (isset($descrizione) && $descrizione !== "") {
            $html .= "Descrizione: " . $descrizione . "<br>";
        }

        $html .= "<br>";
        $html .= setupTipoPrenotazioni($stato, $row["id"]);
        $html .= "</div><br>";
        
        echo $html;
    }

    $stmt->close();
    $conn->close();
}
