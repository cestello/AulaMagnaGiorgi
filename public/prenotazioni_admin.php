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

controllaScaduti();

?>

<!DOCTYPE html>
<html lang="it-IT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
    echo collegaCSS("style");
    echo collegaCSS("index");
    ?>

    <title>
        Prenotazioni Admin
    </title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #F5F5F5;
            margin: 0;
            padding: 0;
        }

        .main-container {
            margin: auto;
            margin-top: 150px;
            background-color: #F5F5F5;
            max-width: 1200px;
            align-items: center;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 10px;
        }


        h2 {
            color: #000;
            margin-bottom: 20px;
        }

        .events-container {
            background-color: #fff;
            margin-bottom: 5px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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

        .button-page[type="button"] {
            background-color: #51758d;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: .5s;
            margin-right: 5px;
            margin-bottom: 5px;
        }

        .button-page[type="button"]:hover {
            background-color: #43667e;
            transform: scale(1.02);
        }

        .main-container a {
            background-color: #51758d;
            color: black;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: .5s;
            margin-right: 5px;
            text-decoration: none;

        }

        .main-container a:hover {
            background-color: #43667e;
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
    <?php include_once "header.php"; ?>
    <div class="main-container">

        <form>
            <div class="type-events-container" id="type-events-container">
                <input class="button-page" type="button" name="nonvisionati" value="Non visionati"
                    id="type-nonvisionati" onClick="gestisci_tipo_richiesta(this.id)">
                <input class="button-page" type="button" name="accettati" value="Accettati" id="type-accettati"
                    onClick="gestisci_tipo_richiesta(this.id)">
                <input class="button-page" type="button" name="rifiutati" value="Rifiutati" id="type-rifiutati"
                    onClick="gestisci_tipo_richiesta(this.id)">
                <input class="button-page" type="button" name="annullati" value="Annullati" id="type-annullati"
                    onClick="gestisci_tipo_richiesta(this.id)">
                <input class="button-page" type="button" name="scaduti" value="Scaduti" id="type-scaduti"
                    onClick="gestisci_tipo_richiesta(this.id)">
            </div><br>
            <h2>
                <div class="events-container" id="events-container">
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "GET" && ($tipo = convertiTipo($_GET["ID"])) !== -1) {
                        if ($tipo === 1) {
                            setupPrenotazioni($tipo, true);
                        } else {
                            setupPrenotazioni($tipo);
                        }
                    } else {
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
    </div>



    <script>
        var current_url = new URL(window.location.href);
        var last_url = current_url.searchParams.get("ID");

        function gestisci_richiesta(ID, name) {
            const URL = `http://138.41.20.100/~rizzello2400/public/prenotazioni_admin.php?ID=${encodeURIComponent(ID)}&name=${encodeURIComponent(name)}`;
            const URL2 = `http://138.41.20.100/~rizzello2400/public/prenotazioni_admin.php?ID=${encodeURIComponent(last_url)}`;
            fetch(URL)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Errore nella richiesta HTTP: ' + response.statusText);
                    }
                    return response.text();
                })
                .then(data => {
                    location.replace(URL2);
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
            last_url = ID;
            const URL = `http://138.41.20.100/~rizzello2400/src/gestione_prenotazioni.php?ID=${encodeURIComponent(ID)}`;
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