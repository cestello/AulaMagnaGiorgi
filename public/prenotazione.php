<?php
session_abort();
session_start();

include_once "../src/utils.php";
include_once "../src/check_cookie.php";

// Se l'utente non è loggato, viene reindirizzato al login
if (!controllaSeLoggato()) {
    header("Location: " . MAINURL . "public/login.php");
    die();
}

include_once "../src/prenotazione.php";

?>

<!DOCTYPE html>
<html lang="it-IT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="http://138.41.20.100/~rizzello2400/public/css/style.css">

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
        #year,
        #day {
            height: 40px;
            width: 160px;
            text-align: center;
            margin-right: 10px;
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

        /* Modifica lo stile del link */
        a {
            color: black;
            text-decoration: none;
        }

        /* a:hover,
        a:active {

        } */
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

        #from,
        #to,
        option {
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

        <label for="year">Seleziona l'anno:</label>
        <select name="year" id="year" onchange="aggiorna()" required>
        </select>

        <label for="month">Seleziona il mese:</label>
        <select name="month" id="month" onchange="aggiorna()" required>
            <!-- Generati automaticamente per la selezione
                automatica del mese corrente -->
        </select>


        <label for="day">Seleziona il giorno:</label>
        <select name="day" id="day" required>
            <!-- Giorni nel dato mese -->
        </select>

        <div id="calendar-container-inner">
            <!-- Genera qui il calendario -->
            <div id="calendar">

            </div>
        </div>

        <label for="from">Orario di inizio </label>
        <select name="from" id="from" onchange="visualizzaOrariValidi()" required>
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
        </select>

        <label for="to">Orario di fine</label>
        <select name="to" id="to" required>
            <!-- Genera in base all'orario di inizio selezionato -->
        </select>

        <label for="titolo">Titolo dell'evento:</label>
        <input type="text" name="titolo" id="titolo" minlength="4" maxlength="64" required>

        <label for="descrizione">Descrizione:</label>
        <textarea name="descrizione" id="descrizione" rows="6" cols="78" maxlength="50"
            style="resize: none;"></textarea>
        <br>

        <div id="submit">
            <input type="submit" value="Prenota">
        </div>
        <?php
        if (isset($_SESSION['message'])) {
            echo "<h2>" . $_SESSION['message'] . "</h2>";
        }
        unset($_SESSION['message']);
        ?>
    </form>

    <script src="http://138.41.20.100/~rizzello2400/public/js/script.js"></script>
    <script>
        // Iniziale generazione del calendario per il mese e l'anno correnti
        const CURRENTDATE = new Date();
        visualizzaOrariValidi();
        sceltaMesi(CURRENTDATE.getMonth());
        sceltaAnni(CURRENTDATE.getFullYear());
        aggiornaTabella();
        sceltaGiorni(CURRENTDATE.getFullYear(), CURRENTDATE.getMonth(), CURRENTDATE.getDate());
    </script>
</body>

</html>
