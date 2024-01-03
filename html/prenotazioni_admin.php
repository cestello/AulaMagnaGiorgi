<?php
session_start();
include('../util/utils.php');
include("../php/check_cookie.php");
if (!check()) {
    header("Location: " . MAINURL . "html/login.php");
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
    <?php
    include("../php/prenotazioni_admin.php");
    ?>
    <br>
    <form action="../index.php">
        <input type="submit" value="Index" />
    </form>
</body>

</html>