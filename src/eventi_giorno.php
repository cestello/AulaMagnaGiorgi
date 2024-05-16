<?php

include_once "../src/utils.php";

/**
 * DEPRECATA
 * Restituisce una stringa HTML contenente tutti gli eventi
 * della data contenuta nel parametro
 *
 * @param string $data da controllare
 * @return string codice HTML
 */
function generaEventiOld($data)
{
    $conn = connectToDatabase();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT titolo, data, ora_inizio, ora_fine, descrizione, email, stato
        FROM eventi WHERE data = ? AND stato = ? ");
    $data = completaData($data);
    $stato = 1;
    $stmt->bind_param("si", $data, $stato);
    
    if ($stmt->execute()) {
        $stmt->store_result();
        $stmt->bind_result($titolo, $data, $ora_inizio, $ora_fine, $descrizione, $email, $stato);
        if ($stmt->num_rows > 0) {
            while ($stmt->fetch()) {
                $risposta = generaHTML(
                    $titolo,
                    $data,
                    $ora_inizio,
                    $ora_fine,
                    $descrizione,
                    $email,
                    $stato
                );
            }
        } else {
            $risposta = "Nessun evento presente";
        }
    } else {
        $risposta = "Errore imprevisto nella query";
    }

    $stmt->close();
    $conn->close();
    return $risposta;
}

/**
 * Restituisce una stringa HTML contenente tutti gli eventi
 * della data contenuta nel parametro
 *
 * @param string $data da controllare
 * @return string codice HTML
 */
function generaEventi($data)
{
    $conn = connectToDatabase();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT titolo, data, ora_inizio, ora_fine, descrizione, email, stato,
        docente_referente, posti, pc_personale, attacco_hdmi, microfono, adattatore_apple, live,
        rete, proiettore, mixer, vga, cavi_audio 
        FROM eventi NATURAL JOIN strumentazioni WHERE data = ? AND stato = ? ORDER BY ora_inizio");
    $data = completaData($data);
    $stato = 1;
    $stmt->bind_param("si", $data, $stato);
    $row = array(
        "data" => "1970-01-01",
        "ora_inizio" => "08:00",
        "ora_fine" => "08:30",
        "docente_referente" => "default",
        "posti" => 80,
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

    $risposta = "";
    if ($stmt->execute()) {
        $stmt->store_result();
        $stmt->bind_result($row["titolo"], $row["data"], $row["ora_inizio"], $row["ora_fine"], $row["descrizione"], $row["email"], $row["stato"],
            $row["docente_referente"], $row["posti"], $row["pc_personale"], $row["attacco_hdmi"], $row["microfono"], $row["adattatore_apple"], $row["live"],
            $row["rete"], $row["proiettore"], $row["mixer"], $row["vga"], $row["cavi_audio"]);
        if ($stmt->num_rows > 0) {
            while ($stmt->fetch()) {
                $risposta .= generaHTML($row);
            }
        } else {
            $risposta = "Nessun evento presente";
        }
    } else {
        $risposta = "Errore imprevisto nella query";
    }

    $stmt->close();
    $conn->close();
    return $risposta;
}

/**
 * Fornisce la data nel formato comunemente utilizzato in Italia ('d-m-Y') a partire
 * dal formato internazionale ('Y-m-d')
 *
 * @param string $data nel formato internazionale
 * @return string data nel formato italiano
 */
function dataItaliana($data)
{
    $data = completaData($data);
    return ottieniGiorno($data) . "/" . ottieniMese($data) . "/" . ottieniAnno($data);
}

/**
 * Genera il link alla pagina del giorno precedente e successivo
 *
 * @param string $data in formato stringa
 * @return string link della pagina
 */
function generaLink($data)
{
    $data = completaData($data);
    $stringa = "public/eventi_giorno.php?anno=" . ottieniAnno($data);
    $stringa .= "&mese=" . ottieniMese($data);
    $stringa .= "&giorno=" . ottieniGiorno($data);
    return $stringa;
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET)) {
    $anno = $_GET["anno"];
    $mese = $_GET["mese"];
    $giorno = $_GET["giorno"];
} else {
    $anno = date('Y');
    $mese = date('m');
    $giorno = date('d');
}

$_GLOBALS["eventiHTML"] = "";
$_GLOBALS["data"] = "";

$data = $anno . "-" . $mese . "-" . $giorno;
$data = completaData($data);
if (convalidaData($data)) {
    $_GLOBALS["data"] = $data;
    $_GLOBALS["eventiHTML"] = generaEventi($data);
} else {
    $_GLOBALS["data"] = "0000-00-00";
    $_GLOBALS["eventiHTML"] = "Data inserita non valida";
}
