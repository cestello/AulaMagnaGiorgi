<?php
session_start();
include('../src/utils.php');
include("../src/check_cookie.php");
if (!check()) {
    header("Location: " . MAINURL . "public/login.php");
    die();
}
include("../src/profilo.php");
$generalita = genera_utente();
$lista_eventi = genera_eventi();
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
        <img src="../resources/LogoGiorgi.png" alt="LogoGiorgi">
        <div class="profile-container">
            <h1>Email:
                <?php echo ($generalita[0]); ?>
            </h1>
            <h1>Nome:
                <?php echo ($generalita[1]); ?>
            </h1>
            <h1>Cognome:
                <?php echo ($generalita[2]); ?>
            </h1>
        </div>

        <div class="events-container">
            <h2>Lista Prenotazioni</h2>
            <?php
            foreach ($lista_eventi as $row) {
                echo ("Nome: " . $row["nome"] . "<br>");
                echo ("Data: " . $row["data"] . "<br>");
                echo ("Ora inizio: " . $row["ora_inizio"] . "<br>");
                echo ("Ora fine: " . $row["ora_fine"] . "<br>");
                echo ("Stato: ");
                if ($row["stato"] == 0) {
                    echo ("non visionato");
                } else if ($row["stato"] == 1) {
                    echo ("accettato");
                } else {
                    echo ("rifiutato");
                }
                echo ("<br><br>");
            }
            ?>
        </div>


        <div class="buttons-container">
            <form action="../src/logout.php">
                <input type="submit" value="Logout" />
            </form>

            <form action="../index.php">
                <input type="submit" value="Index" />
            </form>
        </div>

    </div>
</body>

</html>