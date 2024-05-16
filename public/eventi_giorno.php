<?php
session_abort();
session_start();

include_once "../src/utils.php";
include_once "../src/check_cookie.php";

controllaSeLoggato();

include_once "../src/eventi_giorno.php";

/**
 * Giorno precedente
 */
const PREVIOUS = '-1 day';

/**
 * Giorno successivo
 */
const NEXT = '+1 day';

/**
 * INTERFACCIA CON IL FRONTEND
 * Gestisce la generazione del codice HTML da inserire nella lista degli eventi
 * giornalieri
 *
 * @param array $row array con tutti i diversi valori
 */
function generaHTML($row)
{
    $codiceHTML = "<div class='event-card'>";
    $codiceHTML .= "<h2>" . $row["titolo"] . "</h2>";
    $codiceHTML .= "<p><strong>Ora:</strong> " . substr($row["ora_inizio"], 0, 5) . " - " . substr($row["ora_fine"], 0, 5) . "</p>";
    if (isset($row['descrizione']) && $row['descrizione'] !== "") {
        $codiceHTML .= "<p><strong>Descrizione:</strong> " . $row["descrizione"] . "</p>";
    }
    $codiceHTML .= "<p class='event-docente_referente'><strong>Docente referente:</strong> " . $row["docente_referente"] . "</p>";
    $codiceHTML .= "</div>";

    return $codiceHTML;
}

?>

<!DOCTYPE html>
<html lang="it-IT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <?php
    echo collegaCSS("style");
    echo collegaCSS("index");
    ?>

    <title>
        Eventi giorno
    </title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Titillium Web, sans-serif;
        }

        body {
            background-color: #F5F5F5;
        }

        .main-content {
            margin-top: 100px;
            /* Assicura che il contenuto non venga sovrapposto dall'header */

        }

        B {
            color: rgb(32, 32, 32);
        }

        hr {
            margin-left: 45%;
            width: 10%;

        }

        .main-container {
            max-width: 800px;
            margin: 150px auto 0;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .event-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .event-card h2 {
            font-size: 20px;
            color: #333;
            margin-bottom: 10px;
        }

        .event-card p {
            font-size: 16px;
            color: #555;
            margin-bottom: 8px;
        }

        .event-card strong {
            font-weight: bold;
        }

        .event-card .event-email {
            color: #777;
        }

        .profile-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .buttons-container {
            margin-top: 30px;

        }


        .buttons-container a {
            width: 100%;
            padding: 15px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            background-color: #51758d;
            color: white;
            font-size: 16px;
            cursor: pointer;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .buttons-container>a:hover {
            background-color: #415c72;
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

        . .pre-header-container {
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

    <div class="main-container">
        <?php
        echo '<a style="all: unset; cursor: pointer;" href="' . generaLinkRisorsa() . '">';
        ?>
        </a>
        <div class="profile-container">
            <h1>Eventi del giorno:
                <?php echo dataItaliana($_GLOBALS["data"]); ?>
                <?php ?>
            </h1>
        </div>

        <div class="events-container" id="contenitore-eventi">
            <?php
            echo $_GLOBALS["eventiHTML"];
            ?>
        </div>


        <div class="buttons-container">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                $data = date('Y-m-d', strtotime($_GLOBALS["data"] . PREVIOUS));
            } else {
                $data = date('Y-m-d', strtotime(date('Y-m-d') . PREVIOUS));
            }
            echo '<a href=' . MAINURL . generaLink($data) . '>';
            ?>
            Giorno precedente</a>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                $data = date('Y-m-d', strtotime($_GLOBALS["data"] . NEXT));
            } else {
                $data = date('Y-m-d', strtotime(date('Y-m-d') . NEXT));
            }
            echo '<a href=' . MAINURL . generaLink($data) . '>';
            ?>
            Giorno successivo</a>
        </div>

    </div>

    <?php //include_once "./footer.php"; ?>
</body>

</html>
