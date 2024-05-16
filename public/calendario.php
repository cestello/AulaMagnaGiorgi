<?php

include_once "../src/utils.php";
include_once "../src/check_cookie.php";

controllaSeLoggato();

?>

<!DOCTYPE html>
<html lang="it-IT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
    echo collegaCSS("style");
    ?>

    <title>
        Calendario
    </title>

    <style>
        body {
            background-color: #F5F5F5;
        }

        #calendar-container {
            width: 90%;

            margin: 150px auto 0;
            background-color: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        h2 {
            color: #2370A6;
            font-size: 36px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 18px;
            color: #333;
        }

        select {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
        }



        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        a {
            color: black;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #09407d;
        }

        #seleziona-data {
            width: 60%;
            /* Imposta la larghezza desiderata */
            display: flex;
            justify-content: center;
            /* Centra gli elementi */
            margin: 0 auto;
            /* Centra il wrapper */

        }

        /* Stile per i container dei label e dei select */

        .select-container {
            flex: 0 1 calc(30% - 10px);
            /* Riduci la larghezza e calcola lo spazio disponibile */
            box-sizing: border-box;
            margin: 5px;

        }

        /* Stile per il wrapper del select */
        .select-wrapper {
            margin: auto;
            /* Applica margini automatici per centrare il contenuto */
            text-align: center;
            /* Centra il testo */
        }

        /* Stile per i label */
        .select-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        /* Stile per i menu a tendina */
        .select-container select {
            width: 50%;
            /* Riempie tutto il contenitore */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }


        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Titillium Web, sans-serif;
        }

        .main-content {
            margin-top: 100px;
            /* Assicura che il contenuto non venga sovrapposto dall'header */
        }

        .header-container {
            position: fixed;
            top: 60px;
            /* Altezza del pre-header */
            width: 100%;
            z-index: 1000;
        }

        .header {
            width: 100%;
            padding: 3px 150px;
            background-color: #ffffff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            margin-bottom: 20px;
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.3);
        }

        .pre-header-container {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .pre-header {
            overflow: hidden;
            width: 100%;
            padding: 10px 150px;
            background-color: transparent;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #51758d;
            color: #ffffff;
        }

        span {
            color: #ffffff;
        }

        .header img {
            width: 121px;
            height: 70px;
        }

        .user-icon {
            width: 35px;
            height: 35px;
        }

        .user-icon:hover {
            transform: scale(1.1);
            transition: transform 0.8s ease;
        }

        .nav-bar-pre-header a {
            position: relative;
            font-size: 18px;
            color: #000;
            text-decoration: none;
            font-weight: 500;
            margin-left: 40px;
        }

        .nav-bar-pre-header a::before {
            content: "";
            position: absolute;
            top: 100%;
            left: 0;
            width: 0;
            height: 2px;
            background: #000;
            transition: 0.3s;
        }

        .nav-bar a {
            position: relative;
            font-size: 18px;
            color: #000;
            text-decoration: none;
            font-weight: 500;
            margin-left: 40px;
        }

        .nav-bar a::before {
            content: "";
            position: absolute;
            top: 100%;
            left: 0;
            width: 0;
            height: 2px;
            background: #000;
            transition: 0.3s;
        }

        .pre-header .nav-bar a::before {
            content: "";
            position: absolute;
            top: 100%;
            left: 0;
            width: 0;
            height: 2px;
            background: #ffffff;
            transition: 0.3s;
        }

        .nav-bar a:hover::before {
            width: 100%;
        }

        .mobile-menu {
            display: none;
        }

        .menu-toggle {
            display: none;
        }
    </style>
</head>

<body>
    <?php include_once "./header.php"; ?>

    <div id="calendar-container">
        <?php
        echo '<a href="' . generaLinkRisorsa() . '">';
        ?>
        </a>

        <div id="seleziona-data">
            <div class="select-container">
                <div class="select-wrapper">
                    <label for="month">Seleziona il mese:</label>
                    <select id="month"
                        onchange="aggiornaTabella()"><!-- Generati automaticamente per la selezione automatica del mese corrente --></select>
                </div>
            </div>


            <div class="select-container">
                <div class="select-wrapper">
                    <label for="year">Seleziona l'anno:</label>
                    <select id="year" onchange="aggiornaTabella()">
                        <!-- Generati automaticamente -->
                    </select>
                </div>
            </div>

        </div>

        <div id="calendar-container-inner">
            <!-- Genera qui il calendario -->
            <div id="calendar">

            </div>
        </div>
    </div>

    <?php include_once "./footer.php"; ?>

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