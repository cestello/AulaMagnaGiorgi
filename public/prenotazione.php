<?php
session_abort();
session_start();

include_once "../src/utils.php";
include_once "../src/check_cookie.php";

// Se l'utente non è loggato, viene reindirizzato al login
if (!controllaSeLoggato()) {
    header("Location: " . generaLinkRisorsa("public/login.php"));
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
    <?php
    echo collegaCSS("style");
    ?>

    <title>
        Prenotazione
    </title>

    <style>
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
        /* Aggiornamenti per lo stile del form */

        * {
            margin: 0;
            box-sizing: border-box;
            padding: 0;
            font-family: "Poppins", sans-serif;
        }

        body {
            background-color: #F5F5F5;
        }

        #formCalendario {
            max-width: 80%;
            margin: 150px auto 0;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }


        /* Stile per il wrapper dei menu a tendina */
        #seleziona-data {
            width: 80%;
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
            width: 100%;
            /* Riempie tutto il contenitore */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        #seleziona-orario {
            width: 50%;
            /* Imposta la larghezza desiderata */
            display: flex;
            padding: 20px;
            justify-content: center;
            /* Centra gli elementi */
            margin: 0 auto;
            /* Centra il wrapper */

        }

        .select-container-orario {
            flex: 0 1 calc(30% - 10px);
            /* Riduci la larghezza e calcola lo spazio disponibile */
            box-sizing: border-box;
            margin: 20px;

        }

        .select-container-orario label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }


        .select-container-orario select {
            width: 100%;
            /* Riempie tutto il contenitore */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        #box {
            width: 100%;
            /* Imposta la larghezza desiderata */
            display: flex;
            padding: 20px;
            justify-content: center;
            /* Centra gli elementi */
            margin-right: 10px;
            /* Centra il wrapper */
           
        }

        #titolo-desc {
            width: 60%;
            /* Imposta la larghezza desiderata */

            padding: 20px;
            justify-content: center;
            /* Centra gli elementi */
            margin-right: 10px;
            /* Centra il wrapper */
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.1);

        }

        #accessori-cont {
            width: 40%;
            /* Imposta la larghezza desiderata */
            padding: 10px;
            margin-left: 20px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            /* Due colonne con larghezza flessibile */
            gap: 10px;
            /* Spazio tra le colonne */
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.1);


        }


        /* Stile per le checkbox */
        .checkbox-cont {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .checkbox-cont label {
            display: block;
            margin-left: 10px;
            color: #333;
            /* Colore del testo per le label */
            margin-bottom: 0;
            vertical-align: bottom;
            bottom: -2px;
            /* Allineamento dell'etichetta */
        }

        .checkbox-cont input[type="checkbox"] {
            margin: 0;
            cursor: pointer;
            appearance: none;
            /* Rimuove lo stile predefinito del browser */
            width: 20px;
            /* Dimensione personalizzabile della checkbox */
            height: 20px;
            /* Dimensione personalizzabile della checkbox */
            border: 2px solid #ccc;
            /* Colore del bordo */
            border-radius: 3px;
            /* Bordo arrotondato */
            transition: background-color 0.3s, border-color 0.3s;
            /* Transizione animata */
        }

        /* Stile per la checkbox quando è selezionata */
        .checkbox-cont input[type="checkbox"]:checked {
            background-color: #51758d;
            /* Colore di sfondo quando la checkbox è selezionata */
            border-color: #51758d;
            /* Colore del bordo quando la checkbox è selezionata */
        }

        /* Stile per il segno di spunta all'interno della checkbox */
        .checkbox-cont input[type="checkbox"]:checked::after {
            content: '\2713';
            /* Carattere Unicode per il segno di spunta */
            display: block;
            color: white;
            /* Colore del segno di spunta */
            text-align: center;
            line-height: 20px;
            /* Altezza della checkbox */
        }


        /* Stile per gli input */
        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }


        /* Stile per il pulsante di invio */
        #submit input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            background-color: #51758d;
            color: white;
            font-size: 16px;
            cursor: pointer;
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 18px;
            color: #ffffff;
        }

        #submit input[type="submit"]:hover {
            background-color: #43667e;
            transform: scale(1.02);
        }

        /* Stile per i messaggi di errore o successo */
        #submit .message {
            margin-top: 10px;
            color: #4CAF50;
            font-weight: bold;
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
            content: '';
            position: absolute;
            top: 100%;
            left: 0;
            width: 0;
            height: 2px;
            background: #000;
            transition: .3s;
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
            content: '';
            position: absolute;
            top: 100%;
            left: 0;
            width: 0;
            height: 2px;
            background: #000;
            transition: .3s;
        }

        .pre-header .nav-bar a::before {
            content: '';
            position: absolute;
            top: 100%;
            left: 0;
            width: 0;
            height: 2px;
            background: #ffffff;
            transition: .3s;
        }

        .nav-bar a:hover::before {
            width: 100%;
        }

        /* h5 {
            text-decoration: underline;
        } */


        .close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 24px;
            cursor: pointer;
            color: white;
        }


        .mobile-menu {
            display: none;
        }

        .menu-toggle {
            display: none;
        }


        /* stile per laptop dimensioni s*/
        @media only screen and (max-width: 1050px) {
            .header {
                padding: 3px 70px;
            }

            .pre-header {
                padding: 10px 70px;
            }

        }



        /* Stili per schermi di dimensioni massime (tablet) */
        @media only screen and (max-width: 890px) {
            .header {
                padding: 3px 30px;
            }

            .pre-header {
                padding: 10px 30px;
            }

            .nav-bar a {
                margin-left: 20px;
            }



            .nav-bar a {
                display: none;
            }

            .menu-toggle {
                display: inline-block;
                margin: 2px;
                display: inline-block;
                font-size: 45px;
                color: #333;
                cursor: pointer;
                transition: color 0.7s ease;
                transition: transform 0.5s ease;

            }





            .mobile-menu {
                position: relative;
                top: 100%;
                width: 100%;
                background-color: #51758d;
                margin-bottom: 10px;
                overflow-y: auto;
            }

            .mobile-menu a {
                font-size: 18px;
                display: block;
                font-weight: normal;
                padding: 12px;
                margin: 2px;
                text-align: center;
                text-decoration: none;
                border: solid;
                color: #ffffff;
                overflow: scroll;
            }



            .mobile-menu a:hover {
                background-color: #43667e;
            }
        }






        @media only screen and (max-width: 479px) {}

        /* Stili per schermi di piccole dimensioni (smartphone) */
        @media only screen and (max-width: 479px) {
            .header {
                padding: 3px 20px;
            }

            .pre-header {
                padding: 10px 20px;
            }

            .nav-bar {
                flex-direction: column;
                align-items: center;
            }

            .nav-bar a {
                padding: 8px;
            }

            .nav-bar-pre-header {
                flex-direction: column;
                align-items: center;
            }


            .nav-bar-pre-header a {
                padding: 2px;
                margin-left: 20px;
            }



            .nav-bar a {
                display: none;
            }

            .menu-toggle {
                display: inline-block;
                margin: 2px;
                display: inline-block;
                font-size: 45px;
                color: #333;
                cursor: pointer;
                transition: color 0.7s ease;
                transition: transform 0.5s ease;

            }





            .mobile-menu {
                position: relative;
                top: 100%;
                width: 100%;
                background-color: #51758d;
                margin-bottom: 10px;
            }

            .mobile-menu a {
                font-size: 18px;
                display: block;
                font-weight: normal;
                padding: 12px;
                margin: 2px;
                text-align: center;
                text-decoration: none;
                border: solid;
                color: #ffffff;

            }


            .mobile-menu a:hover {
                background-color: #43667e;
            }

        }
    </style>
</head>

<body>
    <div class="pre-header-container">
        <header class="pre-header">
            <h5>Sito dell'Aula Magna</h5>
            <nav class="nav-bar-pre-header">
                <?php
                if (controllaSeLoggato()) {
                    echo '<a href="' . generaLinkRisorsa("public/profilo.php") . '" class="user-link"><img  src="' . generaLinkRisorsa("resources/icons/user.png") . '" class="user-icon"></a>';
                    echo '<a href="' . generaLinkRisorsa("public/logout.php") . '" class="user-link"><img src="' . generaLinkRisorsa("resources/icons/logout.png") . '" class="user-icon"></a>';
                } else {
                    echo '<a href="' . generaLinkRisorsa("public/login.php") . '" class="user-link"><img src="' . generaLinkRisorsa("resources/icons/login.png") . '" class="user-icon"></a>';
                }
                ?>

            </nav>
        </header>
    </div>

    <div class="header-container">
        <header class="header">
            <?php
            echo '<a href="' . generaLinkRisorsa() . '">';
            echo '<img src="' . generaLinkRisorsa("resources/LogoGiorgi.png") . '" alt="LogoGiorgi">';
            ?>
            <nav class="nav-bar">
                <?php
                echo '<a href="' . generaLinkRisorsa("") . '">Home</a>';
                if (controllaSeLoggato()) {
                    if (controllaSeAdmin()) {
                        echo '<a href="' . generaLinkRisorsa("public/prenotazioni_admin.php") . '">Prenotazioni Admin</a>';
                    }
                    echo '<a href="' . generaLinkRisorsa("public/prenotazione.php") . '">Prenota</a>';
                }
                echo '<a href="' . generaLinkRisorsa("public/calendario.php") . '">Calendario</a>';
                ?>
            </nav>
            <div class="menu-toggle" onclick="toggleMobileMenu()">
                <i class="fas fa-bars"></i>
            </div>
        </header>
        <div class="mobile-menu" id="mobileMenu">
            <?php
            echo '<a href="' . generaLinkRisorsa("") . '">Home</a>';
            if (controllaSeLoggato()) {
                if (controllaSeAdmin()) {
                    echo '<a href="' . generaLinkRisorsa("public/prenotazioni_admin.php") . '">Prenotazioni Admin</a>';
                }
                echo '<a href="' . generaLinkRisorsa("public/prenotazione.php") . '">Prenota</a>';
            }
            echo '<a href="' . generaLinkRisorsa("public/calendario.php") . '">Calendario</a>';
            ?>
        </div>
    </div>

    <form method="post" id="formCalendario">
        <!-- <legend>
            <h1>
                Prenotazione
            </h1>
        </legend> -->

        <?php
        echo '<a href="' . generaLinkRisorsa() . '">';
        ?>
        </a>

        <div id="calendar-container-inner">
            <!-- Genera qui il calendario -->
            <div id="calendar">

            </div>
        </div>

        <div id="seleziona-data">
            <div class="select-container">
                <div class="select-wrapper">
                    <label for="year">Seleziona l'anno:</label>
                    <select name="year" id="year" onchange="aggiorna()" required></select>
                </div>
            </div>
            <div class="select-container">
                <div class="select-wrapper">
                    <label for="month">Seleziona il mese:</label>
                    <select name="month" id="month" onchange="aggiorna()" required></select>
                </div>
            </div>
            <div class="select-container">
                <div class="select-wrapper">
                    <label for="day">Seleziona il giorno:</label>
                    <select name="day" id="day" required></select>
                </div>
            </div>
        </div>

        <div id="seleziona-orario">
            <div class="select-container-orario">
                <div class="select-wrapper">
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
                </div>
            </div>

            <div class="select-container-orario">
                <div class="select-wrapper">
                    <label for="to">Orario di fine</label>
                    <select name="to" id="to" required>
                        <!-- Genera in base all'orario di inizio selezionato -->
                    </select>
                </div>
            </div>
        </div>

        <div id="box">
            <div id="titolo-desc">
                <label for="titolo">Titolo dell'evento:</label>
                <input type="text" name="titolo" id="titolo" minlength="4" maxlength="64" required>

                <label for="descrizione">Descrizione:</label>
                <textarea name="descrizione" id="descrizione" rows="6" cols="78" maxlength="1024"
                    style="resize: none;"></textarea>

                <label for="docente_referente">Professore referente dell'evento:</label>
                <input type="text" name="docente_referente" id="docente_referente" minlength="4" maxlength="64"
                    required>

                <label for="posti">Quanti posti servono all'evento:</label>
                <input type="number" name="posti" id="posti" min="0" max="160" value="80" required>
            </div>

            <div id="accessori-cont">
                <div class="checkbox-cont">
                    <input type="checkbox" id="pc_personale" name="pc_personale"></input>
                    <label for="checkbox">Pc Personale</label>
                </div>

                <div class="checkbox-cont">
                    <input type="checkbox" id="attacco_hdmi" name="attacco_hdmi"></input>
                    <label for="pc">Attacco HDMI</label>
                </div>

                <div class="checkbox-cont">
                    <input type="checkbox" id="microfono" name="microfono"></input>
                    <label for="checkbox">Microfono</label>
                </div>

                <div class="checkbox-cont">
                    <input type="checkbox" id="adattatore_apple" name="adattatore_apple"></input>
                    <label for="checkbox">Adattatore Apple</label>
                </div>

                <div class="checkbox-cont">
                    <input type="checkbox" id="live" name="live"></input>
                    <label for="checkbox">Live</label>
                </div>

                <div class="checkbox-cont">
                    <input type="checkbox" id="rete" name="rete"></input>
                    <label for="checkbox">Internet</label>
                </div>

                <div class="checkbox-cont">
                    <input type="checkbox" id="proiettore" name="proiettore"></input>
                    <label for="checkbox">Proiettore</label>
                </div>

                <div class="checkbox-cont">
                    <input type="checkbox" id="mixer" name="mixer"></input>
                    <label for="checkbox">Mixer</label>
                </div>

                <div class="checkbox-cont">
                    <input type="checkbox" id="vga" name="vga"></input>
                    <label for="checkbox">VGA</label>
                </div>

                <div class="checkbox-cont">
                    <input type="checkbox" id="cavi_audio" name="cavi_audio"></input>
                    <label for="checkbox">Cavi Audio</label>
                </div>
            </div>

        </div>

        <div id="submit">
            <input type="submit" value="Prenota">
        </div>

        <?php
        if (isset($_SESSION['message'])) {
            echo '<h2 style="color:white;">' . $_SESSION['message'] . '</h2>';
        }
        unset($_SESSION['message']);
        ?>
    </form>

    <?php //include_once "./footer.php"; ?>

    <?php
    echo '<script src="' . generaLinkRisorsa("public/js/script.js") . '"></script>';
    ?>
    <script>
        // Iniziale generazione del calendario per il mese e l'anno correnti
        const CURRENTDATE = new Date();
        const ANNO = CURRENTDATE.getFullYear();
        const MESE = CURRENTDATE.getMonth();
        visualizzaOrariValidi();
        sceltaAnni(ANNO);
        sceltaMesi(MESE);
        sceltaGiorni(ANNO, MESE, CURRENTDATE.getDate());
        aggiornaTabella();

    </script>
</body>

</html>