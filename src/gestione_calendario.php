<?php

include_once "./utils.php";

/**
 * Conta la durata di un singolo evento in minuti
 *
 * @param string $fine ora di fine
 * @param string $inizio ora di inizio
 * @return int durata dell'evento in minuti
 */
function contaDurata($fine, $inizio)
{
    $ora_inizio = date_create($inizio);
    $ora_fine = date_create($fine);
    $intervallo = date_diff($ora_fine, $ora_inizio, true);

    $minuti = $intervallo->h * 60;
    $minuti += $intervallo->i;

    return $minuti;
}

/**
 * Calcola la percentuale di minuti occupati dagli eventi
 * nell'arco di una giornata
 *
 * @param int $anno della prenotazione
 * @param int $mese della prenotazione
 * @param int $giorno prenotato
 * @return int percentuale di tempo occupato
 */
function calcolaMinutiOccupati($anno, $mese, $giorno)
{
    $conn = connectToDatabase();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT ora_inizio, ora_fine FROM eventi WHERE data = ? AND stato = ?");
    $data = completaData($anno . "-" . $mese . "-" . $giorno);
    $stato = 1;
    $stmt->bind_param("si", $data, $stato);

    $minutiOccupati = 0;
    if ($stmt->execute()) {
        $stmt->store_result();
        $stmt->bind_result($ora_inizio, $ora_fine);
        while ($stmt->fetch()) {
            $minutiOccupati += contaDurata($ora_fine, $ora_inizio);
        }
    } else {
        $_SESSION['message'] = "Errore nel collegamento";
        $minutiOccupati = -1;
    }
    $stmt->close();
    $conn->close();

    $minutiTotali = 360;
    return($minutiOccupati * 100) / $minutiTotali;
}

/**
 * Restituisce il colore da assegnare ad una cella in base
 * alla percentuale di minuti occupati nella giornata
 *
 * @param int $percentualeOreOccupate percentuale di tempo occupata in un dato giorno
 * @return string colore della cella
 */
function impostaColore($percentualeOreOccupate)
{
    if ($percentualeOreOccupate === 0) {
        $colore = 'verde';
    } elseif ($percentualeOreOccupate > 0 && $percentualeOreOccupate <= 50) {
        $colore = 'giallo';
    } elseif ($percentualeOreOccupate > 50 && $percentualeOreOccupate < 100) {
        $colore = 'arancione';
    } elseif ($percentualeOreOccupate === 100) {
        $colore = 'rosso';
    } else {
        $colore = 'non-definito';
    }
    return $colore;
}

/**
 * Genera la struttura HTML di base della tabella che
 * costituisce il calendario
 *
 * @return string codice HTML dell'intestazione della tabella
 */
function strutturaTabella()
{
    $calendarioHTML = '<table>';
    $calendarioHTML .= '<tr>';
    $calendarioHTML .= '<th>Lun</th>';
    $calendarioHTML .= '<th>Mar</th>';
    $calendarioHTML .= '<th>Mer</th>';
    $calendarioHTML .= '<th>Gio</th>';
    $calendarioHTML .= '<th>Ven</th>';
    $calendarioHTML .= '<th>Sab</th>';
    $calendarioHTML .= '<th>Dom</th>';
    $calendarioHTML .= '</tr>';
    $calendarioHTML .= '<tr>';

    return $calendarioHTML;
}

/**
 * Genera il codice HTML del calendario sottoforma di tabella
 *
 * @param int $anno scelto
 * @param int $mese da visualizzare
 * @return string codice HTML della tabella
 */
function generaCalendario($anno, $mese)
{
    $calendarioHTML = strutturaTabella();

    $primoGiorno = date("N", mktime(0, 0, 0, $mese, 1, $anno));
    $calendarioHTML .= str_repeat('<td></td>', $primoGiorno - 1);

    $giorniInMese = cal_days_in_month(CAL_GREGORIAN, $mese, $anno);

    $mezzaData = $anno . '-' . $mese;
    for ($i = 1; $i <= $giorniInMese; $i++) {
        $data = $mezzaData . '-' . $i;
        $calendarioHTML .= '<td id="' . $data . '" name="' . $data . '" class="';
        $calendarioHTML .= impostaColore(calcolaMinutiOccupati($anno, $mese, $i));
        $calendarioHTML .= '">';
        $calendarioHTML .= '<a href="' . generaLinkRisorsa("public/eventi_giorno.php") . '?anno=' . $anno . '&';
        $calendarioHTML .= 'mese=' . $mese . '&giorno=' . $i . '" target="_blank">';
        $calendarioHTML .= $i . '</a></td>';
        if (($i + $primoGiorno - 1) % 7 == 0) {
            $calendarioHTML .= '</tr><tr>';
        }
    }

    $ultimoGiorno = date("N", mktime(0, 0, 0, $mese, $giorniInMese, $anno));
    $calendarioHTML .= str_repeat('<td></td>', 7 - $ultimoGiorno);
    $calendarioHTML .= '</tr></table>';

    return $calendarioHTML;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $anno = (int) $_GET["year"];
    $mese = $_GET["month"] + 1;
    if ($anno < date("Y")) {
        echo "Anno inserito non valido.";
    } elseif ($mese < 1 || $mese > 12) {
        echo "Mese inserito non valido.";
    } else {
        echo generaCalendario($anno, $mese);
    }
}
