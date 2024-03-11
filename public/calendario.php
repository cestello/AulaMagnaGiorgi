<?php

include_once "../src/utils.php";

?>

<!DOCTYPE html>
<html lang="it-IT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="http://138.41.20.100/~rizzello2400/public/css/style.css">

    <title>
        Calendario
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
            height: 100vh;
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
</head>

<body>
    <div id="calendar-container">
        <?php
        echo '<a href="' . generaLinkRisorsa() . '">';
        echo '<img src="' . generaLinkRisorsa("resources/LogoGiorgi.png") . '" alt="LogoGiorgi">';
        ?>
        </a>


        <label for="month">Seleziona il mese:</label>
        <select id="month" onchange="aggiornaTabella()">
            <!-- Generati automaticamente per la selezione
                automatica del mese corrente -->
        </select>

        <label for="year">Seleziona l'anno:</label>
        <select id="year" onchange="aggiornaTabella()">
            <!-- Generati automaticamente -->
        </select>

        <div id="calendar-container-inner">
            <!-- Genera qui il calendario -->
            <div id="calendar">

            </div>
        </div>
    </div>
    
    <?php
    echo '<script src="' . generaLinkRisorsa("public/js/script.js") . '"></script>';
    ?>
    <script>
        // Iniziale generazione del calendario per il mese e l'anno correnti
        const currentDate = new Date();
        sceltaMesi(currentDate.getMonth());
        sceltaAnni(currentDate.getFullYear());
        aggiornaTabella();
    </script>
</body>

</html>
