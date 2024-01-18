<?php
include("./utils.php");

function contaDurata($fine, $inizio)
{
    $ora_inizio = date_create($inizio);
    $ora_fine = date_create($fine);
    $intervallo = date_diff($ora_fine, $ora_inizio, true);
    
    $minuti = $intervallo->h * 60;
    $minuti += $intervallo->i;

    return $minuti;
}

function calcolaMinutiOccupati($year, $month, $day)
{
    $conn = connect_to_database();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql_query = "SELECT * FROM eventi WHERE data='" . $year . "-" . $month . "-" . $day . "' AND stato=1;";
    $query_answer = $conn->query($sql_query);
    $minutiOccupati = 0;
    if ($query_answer === FALSE) {
        $_SESSION['message'] = "Errore nel collegamento";
        $minutiOccupati = -1;
    } else {
        $records = array();
        while ($row = $query_answer->fetch_assoc()) {
            $records[] = $row;
        }

        if (sizeof($records) > 0) {
            foreach ($records as $row) {
                $minutiOccupati += contaDurata($row["ora_fine"], $row["ora_inizio"]);
            }
        }
    }
    $conn->close();

    $minutiTotali = 360;
    return ($minutiOccupati * 100) / $minutiTotali;
}

function impostaColore($percentualeOreOccupate)
{
    if ($percentualeOreOccupate >= 0 && $percentualeOreOccupate < 25) {
        $colore = 'verde';
    } else if ($percentualeOreOccupate >= 25 && $percentualeOreOccupate < 50) {
        $colore = 'giallo';
    } else if ($percentualeOreOccupate >= 50 && $percentualeOreOccupate < 75) {
        $colore = 'arancione';
    } else if ($percentualeOreOccupate >= 75 && $percentualeOreOccupate <= 100) {
        $colore = 'rosso';
    } else {
        $colore = 'non-definito';
    }
    return $colore;
}

function strutturaTabella($year, $month)
{
    $date = DateTime::createFromFormat('!m', $month);
    $monthName = $date->format('F');

    $calendarHTML = '<h3>' . $monthName . ' ' . $year . '</h3>';
    $calendarHTML .= '<table>';
    $calendarHTML .= '<tr>';
    $calendarHTML .= '<th>Lun</th>';
    $calendarHTML .= '<th>Mar</th>';
    $calendarHTML .= '<th>Mer</th>';
    $calendarHTML .= '<th>Gio</th>';
    $calendarHTML .= '<th>Ven</th>';
    $calendarHTML .= '<th>Sab</th>';
    $calendarHTML .= '<th>Dom</th>';
    $calendarHTML .= '</tr>';
    $calendarHTML .= '<tr>';

    return $calendarHTML;
}


function generaCalendario($year, $month)
{
    $calendarHTML = strutturaTabella($year, $month);

    $firstDay = date("N", mktime(0, 0, 0, $month, 1, $year));
    $calendarHTML .= str_repeat('<td></td>', $firstDay - 1);

    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    for ($i = 1; $i <= $daysInMonth; $i++) {
        $calendarHTML .= '<td class="';
        $calendarHTML .= impostaColore(calcolaMinutiOccupati($year, $month, $i));
        $calendarHTML .= '">' . $i . '</td>';
        if (($i + $firstDay - 1) % 7 == 0) {
            $calendarHTML .= '</tr><tr>';
        }
    }

    $lastDay = date("N", mktime(0, 0, 0, $month, $daysInMonth, $year));
    $calendarHTML .= str_repeat('<td></td>', 7 - $lastDay);
    $calendarHTML .= '</tr></table>';

    return $calendarHTML;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $year = (int) $_GET["year"];
    $month = $_GET["month"] + 1;
    if ($year < date("Y")) {
        echo ("Anno inserito non valido.");
    } else if ($month < 1 || $month > 12) {
        echo ("Mese inserito non valido.");
    } else {
        echo (generaCalendario($year, $month));
    }
}