<?php
session_start();
include('../util/utils.php');
include("../php/check_cookie.php");
if (!check()) {
    header("Location: " . MAINURL . "html/login.php");
    die();
}
include("../php/profilo.php");
?>

<!DOCTYPE html>
<html lang="it-IT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilo</title>
</head>

<body>
    <h1>
        Email:
        <?php echo ($email); ?>
    </h1> <br>
    <h1>
        Nome:
        <?php echo ($nome); ?>
    </h1> <br>
    <h1>
        Cognome:
        <?php echo ($cognome); ?>
    </h1> <br>
    <form action="../php/logout.php">
        <input type="submit" value="Logout" />
    </form>
    <form action="../index.php">
        <input type="submit" value="Index" />
    </form>

</body>

</html>