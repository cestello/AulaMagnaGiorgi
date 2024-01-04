<?php
    session_start();
    include('../src/utils.php');
    include("../src/check_cookie.php");
    if (!check()) {
        header("Location: " . MAINURL . "public/login.php");
        die();
    }
    if (!check_admin()) {
        header("Location: " . MAINURL . "index.php");
        die();
    }
?>

<!DOCTYPE html>
<html lang="it-IT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilo</title>
</head>

<body>
    <h2>
    <?php
        include("../src/prenotazioni_admin.php");
    ?>
    </h2>
    <br>
    <form action="../index.php">
        <input type="submit" value="Index" />
    </form>
</body>

</html>