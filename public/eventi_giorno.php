<?php
session_abort();
session_start();

include_once "../src/utils.php";
include_once "../src/eventi_giorno.php";

/**
 * INTERFACCIA CON IL FRONTEND
 * Gestisce la generazione del codice HTML da inserire nella lista degli eventi
 * giornalieri
 *
 * @param string $titolo dell'evento
 * @param string $data dell'evento
 * @param string $oraInizio orario di inizio
 * @param string $oraFine orario di fine
 * @param string $descrizione dell'evento
 * @param string $email dell'utente richiedente
 * @param string $stato dell'evento
 * @return string codice HTML rappresentante un evento
 */
function generaHTML($titolo, $data, $oraInizio, $oraFine, $descrizione, $email, $stato) {
    $codiceHTML = "<p>";
    $codiceHTML .= $titolo . " " . $data . " " . $oraInizio . " ";
    $codiceHTML .= $oraFine . " " . $descrizione . " " . $email . " ";
    $codiceHTML .= $stato;
    $codiceHTML .= "</p>";
    return $codiceHTML;
}

?>

<!DOCTYPE html>
<html lang="it-IT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Eventi giorno
    </title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to left, #b9cfec, #b4c8d4);
            margin: 0;
            padding: 0;
        }

        .main-container {
            background: linear-gradient(to bottom, #b4c8d4, #3979cc);
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
        }

        .profile-container,
        .events-container {
            background-color: #F5F5F5;
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        h1,
        h2 {
            color: #333;
        }

        .profile-container h1 {
            margin-bottom: 10px;
        }

        .events-container h2 {
            margin-bottom: 10px;
        }

        .events-container p {
            margin: 0;
        }

        .buttons-container {
            display: flex;
            justify-content: space-between;
        }

        .buttons-container form {
            margin: 0;
            /* Remove default form margin */
        }

        img {
            display: block;
            margin: 0 auto;
            width: 243px;
            height: 138px;
            padding: 5px;
            margin-bottom: 10px;
        }

        a {
            background-color: #043370;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: .5s;
            margin-right: 5px;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            background-color: #BC2047;
            transform: scale(1.02);
        }

        input[type="submit"] {
            background-color: #043370;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: .5s;
        }

        input[type="submit"]:hover {
            background-color: #BC2047;
            transform: scale(1.03);
        }

        @media screen and (max-width: 600px) {
            .main-container {
                padding: 10px;
            }

            .buttons-container {
                flex-direction: column;
            }

            input[type="submit"] {
                width: 100%;
                margin: 10px 0;
            }
        }
    </style>
</head>

<body>
    <div class="main-container">
        <a style="all: unset;" href="http://138.41.20.100/~rizzello2400/">
            <img src="../resources/LogoGiorgi.png" alt="LogoGiorgi">
        </a>
        <div class="profile-container">
            <h1>Eventi del giorno: <?php echo dataItaliana($_GLOBALS["data"]); ?>
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
</body>

</html>
