<?php
session_start();
include('../src/utils.php');
include("../src/check_cookie.php");
if (!check()) {
    header("Location: " . MAINURL . "public/login.php");
    die();
}
include("../src/prenotazione.php");
?>

<!DOCTYPE html>
<html lang="it-IT">
<head>
    <title>
        Prenotazione
    </title>

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

        h3 {
            text-align: center;
            color: rgba(255, 255, 255, 1);
            /* color: #2370A6; */
            /* font-size: 36px; */
            margin-bottom: 20px;
            /* margin-bottom: 33px; */
            font-family: 'Open Sans', sans-serif;
        }

        #calendar-container-inner {
            padding-bottom: 3rem;
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
        <a href="http://138.41.20.100/~rizzello2400/">
            <img src="../resources/LogoGiorgi.png" alt="LogoGiorgi">
        </a>

        <h1>Prenotazione</h1>

        <label for="month">Seleziona il mese:</label>
        <select id="month" onchange="updateTable()">
            <option value="0" selected>Gennaio</option>
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
        <select id="year" onchange="updateTable()">
        </select>

        <div id="calendar-container-inner">
            <!-- Genera qui il calendario -->
            <div id="calendar">
                <!-- <?php
                include("../src/gestione_calendario.php");
                echo (generateCalendar(date("Y"), date("m")));
                ?> -->
            </div>
        </div>

        <label for="from">Orario di inizio </label>
        <select name="from" id="from" onchange="validTime()">
            <option value="0" selected>8:00</option>
            <option value="1">8:30</option>
            <option value="2">9:00</option>
            <option value="3">9:30</option>
            <option value="4">10:00</option>
            <option value="5">10:30</option>
            <option value="6">11:00</option>
            <option value="7">11:30</option>
            <option value="8">12:00</option>
            <option value="9">12:30</option>
            <option value="10">13:00</option>
            <option value="11">13:30</option>
        </select>

        <label for="to">Orario di fine</label>
        <select name="to" id="to">
            <!-- Genera in base all'orario di inizio selezionato -->
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

    <?php include("../src/prenotazione.php") ?>

    <script>
        function updateYears(year) {
            let years = "";
            let i;
            for (i = 0; i < 5; i++) {
                years += `<option value=\"${year + i}\">${year + i}</option>\n`;
            }
            document.getElementById("year").innerHTML = years;
        }

        function validTime() {
            let initialTime = parseInt(document.getElementById("from").value);
            let times = [
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
            ];

            let new_times = "";
            let i;
            for (i = initialTime + 1; i < times.length; ++i) {
                new_times += `<option value=\"${i}\">${times[i]}</option>`
            }
            document.getElementById("to").innerHTML = new_times;
        }

        function updateTable() {
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    document.getElementById("calendar").innerHTML = this.responseText;
                }
            };
            
            let year = document.getElementById("year").value;
            let month = parseInt(document.getElementById("month").value);
            let URL = "http://138.41.20.100/~rizzello2400/src/gestione_calendario.php?year=" + encodeURIComponent(year) + "&month=" + encodeURIComponent(month);
            xmlhttp.open("GET", URL, true);
            xmlhttp.send();
        }

        // Iniziale generazione del calendario per il mese e l'anno corrente
        const currentDate = new Date();
        updateYears(currentDate.getFullYear());
        validTime();
        updateTable();
    </script>
</body>

</html>