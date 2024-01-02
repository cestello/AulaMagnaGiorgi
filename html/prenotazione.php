<?php
session_start();
include('../util/utils.php');
include("../php/check_cookie.php");
if (!check()) {
    header("Location: " . $url . "html/login.php");
    die();
}
include("../php/prenotazione.php");
?>
<!DOCTYPE html>
<html lang="it-IT">

<head>
    <title>Prenotazione</title>

    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            text-align: center;
            background: linear-gradient(to left, #b9cfec, #b4c8d4);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        label {
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 18px;
            color: #ffffff;
        }

        h2 {
            text-align: center;
            color: #2370A6;
            font-size: 36px;
            margin-bottom: 33px;
            font-family: 'Open Sans', sans-serif;
        }

        #calendar-container {
            width: 1100px;
            height: 770px;
            margin: 4% auto;
            background: linear-gradient(to bottom, #b4c8d4, #3979cc);
            padding: 2%;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #month,
        #year {
            margin-right: 10px;
            width: min-content;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        img {
            display: block;
            margin: 0 auto;
            width: 243px;
            height: 138px;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            font-weight: bold;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>

    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background: linear-gradient(to left, #b9cfec, #b4c8d4);
        }

        #formCalendario {
            max-width: 600px;
            margin: 4% auto;
            background: linear-gradient(to bottom, #b4c8d4, #3979cc);
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #formCalendario h1 {
            text-align: center;
            color: #2370A6;
            font-size: 36px;
            margin-bottom: 33px;
            font-family: 'Open Sans', sans-serif;
        }

        #formCalendario label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 18px;
            color: #ffffff;
        }

        #formCalendario input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        #formCalendario input[type="submit"] {
            background-color: #043370;
            color: white;
            font-weight: bold;
            font-size: 17px;
            padding: 10px 15px;
            cursor: pointer;
            border: none;
            transition: .5s;

        }

        #formCalendario input[type="submit"]:hover {
            background-color: #BC2047;
            transform: scale(1.03);
        }


        #formCalendario img {
            display: block;
            margin: 0 auto;
            width: 243px;
            height: 138px;
        }

        a {
            color: #BC2047;
            font-weight: bold;

        }

        #motivazione {
            resize: none;
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 6px;

        }

        #from,
        #to {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
    </style>
</head>

<body>
    <form method="post" id="formCalendario">
        <img src="../img/LogoGiorgi.png" alt="LogoGiorgi">

        <h1>Prenotazione</h1>

        <label for="month">Seleziona il mese:</label>
        <select id="month" onchange="updateCalendar()">
            <option value="0">Gennaio</option>
            <option value="1">Febbraio</option>
            <option value="2">Marzo</option>
            <option value="3">Aprile</option>
            <option value="4">Maggio</option>
            <option value="5">Giugno</option>
            <option value="6">Luglio</option>
            <option value="7">Agosto</option>
            <option value="8">Settembre</option>
            <option value="9">Ottobre</option>
            <option value="10">Novembre</option>
            <option value="11">Dicembre</option>
        </select>

        <label for="year">Seleziona l'anno:</label>
        <select id="year" onchange="updateCalendar()">
            <!-- Imposta gli anni dal 2023 al 2030 -->
            <option value="2024">2024</option>
        </select>

        <div id="calendar-container-inner">
            <!-- Genera qui il calendario -->
            <div id="calendar">
                <!-- <?php
                    function generateCalendar($year, $month) {
                        $calendarHTML = '';
                        $months = [
                            "Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno",
                            "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"
                        ];
                    
                        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                        $firstDay = date("N", mktime(0, 0, 0, $month, 1, $year));
                        $lastDay = date("N", mktime(0, 0, 0, $month, $daysInMonth, $year));
                    
                        $calendarHTML .= '<h2>' . $months[$month - 1] . ' ' . $year . '</h2>';
                        $calendarHTML .= '<table>';
                        $calendarHTML .= '<tr>';
                        $calendarHTML .= '<th>Dom</th>';
                        $calendarHTML .= '<th>Lun</th>';
                        $calendarHTML .= '<th>Mar</th>';
                        $calendarHTML .= '<th>Mer</th>';
                        $calendarHTML .= '<th>Gio</th>';
                        $calendarHTML .= '<th>Ven</th>';
                        $calendarHTML .= '<th>Sab</th>';
                        $calendarHTML .= '</tr>';
                        $calendarHTML .= '<tr>';
                    
                        for ($i = 0; $i < $firstDay; $i++) {
                            $calendarHTML .= '<td></td>';
                        }
                    
                        for ($i = 1; $i < $daysInMonth; $i++) {
                            $calendarHTML .= '<td>' . $i . '</td>';
                            if (($i + $firstDay) % 7 == 0) {
                                $calendarHTML .= '</tr><tr>';
                            }
                        }
                    
                        for ($i = $lastDay; $i < 7; $i++) {
                            $calendarHTML .= '<td></td>';
                        }
                    
                        $calendarHTML .= '</tr></table>';
                    
                        return $calendarHTML;
                    }
                    
                    $anno = 2024;
                    $mese = 1; // Gennaio
                    echo(generateCalendar($anno, $mese));                    
                ?> -->
            </div>
        </div>

        <label for="from">Orario di inizio </label>
        <select name="from" id="from">
            <option value="1">8:00</option>
            <option value="1">8:30</option>
            <option value="2">9:00</option>
            <option value="2">9:30</option>
            <option value="3">10:00</option>
            <option value="3">10:30</option>
            <option value="4">11:00</option>
            <option value="4">11:30</option>
            <option value="5">12:00</option>
            <option value="5">12:30</option>
            <option value="6">13:00</option>
        </select>

        <label for="to">Orario di fine</label>
        <select name="to" id="to">
            <option value="1">9:00</option>
            <option value="1">9:30</option>
            <option value="2">10:00</option>
            <option value="2">10:30</option>
            <option value="3">11:00</option>
            <option value="3">11:30</option>
            <option value="4">12:00</option>
            <option value="4">12:30</option>
            <option value="5">13:00</option>
            <option value="5">13:30</option>
            <option value="6">14:00</option>
        </select>

        <label for="evento">Nome dell'evento:</label>
        <input type="text" id="evento" required>

        <label for="motivazione">Motivazione:</label>
        <textarea id="motivazione" rows="6" cols="78" maxlength="50"></textarea>
        <br>
        <div id="submit">
            <input type="submit" value="Prenota">
        </div>
    </form>

    <?php include("../php/prenotazione.php") ?>

    <script>
        function generateCalendar(year, month) {
            const calendar = document.getElementById("calendar");
            const months = [
                "Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno",
                "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"
            ];


            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const firstDayIndex = new Date(year, month, 1).getDay();
            const lastDayIndex = new Date(year, month, daysInMonth).getDay();

            let calendarHTML = `<h2>${months[month]} ${year}</h2>
                <table>
                <tr>
                <th>Dom</th>
                <th>Lun</th>
                <th>Mar</th>
                <th>Mer</th>
                <th>Gio</th>
                <th>Ven</th>
                <th>Sab</th>
                
                </tr>
                <tr>`;

            for (let i = 0; i < firstDayIndex; i++) {
                calendarHTML += "<td></td>";
            }

            for (let i = 1; i <= daysInMonth; i++) {
                calendarHTML += `<td>${i}</td>`;
                if ((i + firstDayIndex) % 7 === 0) {
                    calendarHTML += "</tr><tr>";
                }
            }

            for (let i = lastDayIndex + 1; i < 7; i++) {
                calendarHTML += "<td></td>";
            }

            calendarHTML += "</tr></table>";
            calendar.innerHTML = calendarHTML;
        }

        function updateCalendar() {
            const year = parseInt(document.getElementById("year").value);
            const month = parseInt(document.getElementById("month").value);
            generateCalendar(year, month);
        }

        // Iniziale generazione del calendario per il mese e l'anno corrente
        const currentDate = new Date();
        document.getElementById("month").value = currentDate.getMonth().toString();
        document.getElementById("year").value = currentDate.getFullYear().toString();
        generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
    </script>
</body>

</html>