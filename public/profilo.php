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

    <?php
    echo collegaCSS("style");
    ?>

    <title>
        Profilo
    </title>

    <style>
        body {
            font-family: 'Arial', sans-serif;

            margin: 0;
            padding: 0;
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

        .main-container {

            width: 100%;
            display: flex;
            margin: auto 0;
            background-color: #F5F5F5;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

            border-radius: 8px;
        }

        .profile-container {
            width: 30%;
            background-color: #F5F5F5;


            border: 1px solid #ddd;

        }

        .events-container {
            width: 70%;
            background-color: #F5F5F5;
            margin-top: 160px;
            
            display: grid;
            padding: 10px 40px;;
            /* border: 1px solid #ddd; */

            grid-template-columns: repeat(4, 1fr);
            /* Distribuisce gli eventi su 4 colonne */
            gap: 20px;
            justify-content: center;
            
        }

        .testo-profilo {
            position: sticky;
            margin: 250px 30px;
            
            padding: 20px;
            justify-content: center;
            text-align: center;
            background-color: #51758d;
            color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .evento {
            height: 400px;
            background-color: #fff;
            justify-content: center;
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            margin: auto 0;
            width: 250px;
            border-radius: 5px;
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.3);
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
    </style>
</head>

<body>
    <?php include_once "./header.php"; ?>

    <div class="main-container">
        <div class="profile-container">
            <div class="testo-profilo">
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
        </div>

        <div class="events-container">

            <?php
            if (sizeof($lista_eventi) <= 0) {
                echo "Nessun evento prenotato";
            } else {
                foreach ($lista_eventi as $evento) {
                    echo "<div class='evento'>" . $evento . "</div>";
                }
            }
            ?>
        </div>

    </div>

    <?php include_once "./footer.php"; ?>
</body>

</html>
