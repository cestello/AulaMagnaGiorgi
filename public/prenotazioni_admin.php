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

// Se l'utente non è admin, viene reindirizzato all'index
if (!controllaSeAdmin()) {
    header("Location: " . generaLinkRisorsa());
    die();
}

include_once "../src/prenotazioni_admin.php";

// controllaScaduti();

?>

<!DOCTYPE html>
<html lang="it-IT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Prenotazioni Admin
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

        img {
            display: block;
            margin: 0 auto;
            width: 243px;
            height: 138px;
            padding: 5px;
            margin-bottom: 10px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .events-container {
            background-color: rgba(245, 245, 245, 0.7);
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
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
            margin-top: 20px;
        }

        .buttons-container form {
            margin: 0;
        }

        input[type="button"] {
            background-color: #043370;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: .5s;
            margin-right: 5px;
        }

        input[type="button"]:hover {
            background-color: #BC2047;
            transform: scale(1.02);
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

        @media screen and (max-width: 600px) {
            .main-container {
                padding: 10px;
            }

            .buttons-container {
                flex-direction: column;
            }

            input[type="button"] {
                width: 100%;
                margin: 10px 0;
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
        <br>

        <form>
            <div class="type-events-container" id="type-events-container">
                <input type="button" name="nonvisionati" value="Non visionati" id="type-nonvisionati"
                    onClick="gestisci_tipo_richiesta(this.id)">
                <input type="button" name="accettati" value="Accettati" id="type-accettati"
                    onClick="gestisci_tipo_richiesta(this.id)">
                <input type="button" name="rifiutati" value="Rifiutati" id="type-rifiutati"
                    onClick="gestisci_tipo_richiesta(this.id)">
                <input type="button" name="annullati" value="Annullati" id="type-annullati"
                    onClick="gestisci_tipo_richiesta(this.id)">
                <input type="button" name="scaduti" value="Scaduti" id="type-scaduti"
                    onClick="gestisci_tipo_richiesta(this.id)">
            </div>
            <h2>
                <div class="events-container" id="events-container">
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET)) {
                        setupPrenotazioni(0);
                    }

                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                    }
                    unset($_SESSION['message']);
                    ?>
                </div>
                <h1 id="closer"></h1>
            </h2><br>
        </form>

        <?php
        echo '<a href="' . generaLinkRisorsa() . '">Index</a>';
        ?>
    </div>
    <script>
        function gestisci_richiesta(ID, name) {
            const URL = `http://138.41.20.100/~rizzello2400/public/prenotazioni_admin.php?
                ID=${encodeURIComponent(ID)}&name=${encodeURIComponent(name)}`;
            fetch(URL)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Errore nella richiesta HTTP: ' + response.statusText);
                    }
                    return response.text();
                })
                .then(data => { 
                    location.replace("http://138.41.20.100/~rizzello2400/public/prenotazioni_admin.php");
                })
                .catch(error => {
                    if (error.name === 'TypeError') {
                        console.error('Errore di rete: ', error.message);
                    } else {
                        console.error('Si è verificato un errore imprevisto: ', error.message);
                    }
                });
        }

        function gestisci_tipo_richiesta(ID) {
            const URL = `http://138.41.20.100/~rizzello2400/src/gestione_prenotazioni.php?
                ID=${encodeURIComponent(ID)}`;
            fetch(URL)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Errore nella richiesta HTTP: ' + response.statusText);
                    }
                    return response.text();
                })
                .then(data => {
                    // location.replace("http://138.41.20.100/~rizzello2400/public/prenotazioni_admin.php");
                    document.getElementById("events-container").innerHTML = data;
                })
                .catch(error => {
                    if (error.name === 'TypeError') {
                        console.error('Errore di rete: ', error.message);
                    } else {
                        console.error('Si è verificato un errore imprevisto: ', error.message);
                    }
                });
        }
    </script>

</body>

</html>
