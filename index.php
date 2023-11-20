<!DOCTYPE html>
<html lang="it-IT">
    <head>
        <title>
            INDEX
        </title>
    </head>

    <body>
        <?php include("./index_p.php") ?>

        <form action="./signin.php" method="post">
            <label for="nome"></label><input type="text" id="nome" required>
            <label for="cognome"></label><input type="text" id="cognome" required>
            <label for="email"></label><input type="email" id="email" required>
            <label for="password"></label><input type="password" id="password" required>
            <input type="submit">
        </form>
    </body>
</html>