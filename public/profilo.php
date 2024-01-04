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
</head>

<body>
    <h1>
        Email:
        <?php echo ($generalita[0]); ?>
    </h1><br>

    <h1>
        Nome:
        <?php echo ($generalita[1]); ?>
    </h1><br>

    <h1>
        Cognome:
        <?php echo ($generalita[2]); ?>
    </h1><br>

    <h2> Lista Prenotazioni: <br>
        <?php
        foreach($lista_eventi as $row) {
            echo("Nome: " . $row["nome"] . " Data: " . $row["data"] . " Ora inizio: " . $row["ora_inizio"] . " Ora fine: " . $row["ora_fine"] . "<br>");
            echo("Stato: ");
            if($row["stato"] == 0) {
                echo("non visionato");
            } else if($row["stato"] == 1) {
                echo("accettato");
            } else {
                echo("rifiutato");
            }
            echo("<br><br>");
        }
        ?>
    </h2>

    <form action="../src/logout.php">
        <input type="submit" value="Logout" />
    </form>

    <form action="../index.php">
        <input type="submit" value="Index" />
    </form>
</body>
</html>