<?php

$months = [
    "Gennaio",
    "Febbraio",
    "Marzo",
    "Aprile",
    "Maggio",
    "Giugno",
    "Luglio",
    "Agosto",
    "Settembre",
    "Ottobre",
    "Novembre",
    "Dicembre"
];

function generateCalendar($year, $month)
{
    global $months;
    $calendarHTML = '';

    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $firstDay = date("N", mktime(0, 0, 0, $month, 1, $year));
    $lastDay = date("N", mktime(0, 0, 0, $month, $daysInMonth, $year));

    $calendarHTML .= '<h3>' . $months[$month - 1] . ' ' . $year . '</h3>';
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

    $calendarHTML .= str_repeat('<td></td>', $firstDay - 1);

    for ($i = 1; $i <= $daysInMonth; $i++) {
        $calendarHTML .= '<td>' . $i . '</td>';
        if (($i + $firstDay - 1) % 7 == 0) {
            $calendarHTML .= '</tr><tr>';
        }
    }

    for ($i = $lastDay; $i < 7; $i++) {
        $calendarHTML .= '<td></td>';
    }

    $calendarHTML .= '</tr></table>';
    return $calendarHTML;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $year = (int) $_REQUEST["year"];
    $month = array_search($_REQUEST["month"], $months) + 1;
    echo (generateCalendar($year, $month));
}