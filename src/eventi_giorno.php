<?php

include_once "../src/utils.php";

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

    $sql_query = "SELECT * FROM eventi WHERE data='" . $data . "' AND stato=1;";
    $query_answer = $conn->query($sql_query);
    $risposta = "";
    if ($query_answer === false) {
        $risposta = "Errore nel collegamento";
    } else {
        $records = array();
        while ($row = $query_answer->fetch_assoc()) {
            $records[] = $row;
        }

        if (!empty($records)) {
            foreach ($records as $row) {
                $risposta = generaHTML(
                    $row["titolo"],
                    $row["data"],
                    $row["ora_inizio"],
                    $row["ora_fine"],
                    $row["descrizione"],
                    $row["email"],
                    $row["stato"]
                );
            }
        } else {
            $risposta = "Nessun evento presente";
        }
    }
    $conn->close();
    return $risposta;
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
    if (strlen($data) === 8) {
        $data = substr($data, 0, 5) . "0" . substr($data, 5, 2) . "0" . substr($data, 7, 2);
    } elseif (strlen($data) === 9) {
        // 0123456789
        // 2222-11-00
        if ($data[6] == "-") {
            $data = substr($data, 0, 5) . "0" . substr($data, 5, 4);
        } else {
            $data = substr($data, 0, 7) . "0" . substr($data, 7, 2);
        }
    }
    return $data;
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
