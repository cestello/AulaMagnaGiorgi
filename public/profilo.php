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

include_once "../src/profilo.php";

$generalita = generaUtente();
$lista_eventi = generaEventi();

?>

<!DOCTYPE html>
<html lang="it-IT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Profilo
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
            border-radius: 5px;
            cursor: pointer;
            transition: .5s;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
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

            a {
                width: 100%;
                margin: 10px 0;
            }
        }
    </style>
</head>

<body>
    <div class="main-container">
        <?php
        echo '<a style="all: unset; cursor: pointer;" href="' . generaLinkRisorsa() . '">';
        echo '<img src="' . generaLinkRisorsa("resources/LogoGiorgi.png") . '" alt="LogoGiorgi">';
        ?>
        </a>
        <div class="profile-container">
            <h1>Email:
                <?php echo $generalita["email"]; ?>
            </h1>
            <h1>Nome:
                <?php echo $generalita["nome"]; ?>
            </h1>
            <h1>Cognome:
                <?php echo $generalita["cognome"]; ?>
            </h1>
        </div>

        <div class="events-container">
            <h2>Lista Prenotazioni</h2>
            <?php
            if (sizeof($lista_eventi) <= 0) {
                echo "Nessun evento prenotato";
            } else {
                foreach ($lista_eventi as $row) {
                    echo "Nome: " . $row["titolo"] . "<br>";
                    echo "Data: " . $row["data"] . "<br>";
                    echo "Ora inizio: " . $row["ora_inizio"] . "<br>";
                    echo "Ora fine: " . $row["ora_fine"] . "<br>";
                    echo "Stato: ";
                    if ($row["stato"] === 0) {
                        echo "non visionato";
                    } elseif ($row["stato"] === 1) {
                        echo "accettato";
                    } elseif ($row["stato"] === 2) {
                        echo "rifiutato";
                    } elseif ($row["stato"] === 3) {
                        echo "annullato";
                    } elseif ($row["stato"] === 4) {
                        echo "scaduto";
                    } else {
                        echo "errore nel determinare lo stato";
                    }
                    echo "<br>";
                    echo "Professore Referente: " . $row["professore_referente"] . "<br>";
                    echo "Posti: " . $row["posti"] . "<br>";
                    echo "<br><br>";
                }
            }
            ?>
        </div>


        <div class="buttons-container">
            <?php
            echo '<a href="' . generaLinkRisorsa("src/logout.php") . '">Logout</a>';
            echo '<a href="' . generaLinkRisorsa() . '">Index</a>';
            ?>
        </div>
    </div>
</body>

</html>
