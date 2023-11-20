<!DOCTYPE html>
<html>
    <head>

    </head>

    <body>
        <?php
            include('./utils.php');

            if ($_SERVER["REQUEST_METHOD"] == "POST")
            {
                $email = $_POST["email"];
                $password = $_POST["password"];

                if (is_used($email))
                {
                    // TODO: check is password is correct [database]
                }
                else
                {
                    echo("Account inesistente");
                }
            }
        ?>

        <form action="./login.php" method="post">
            <input type="email" id="email" required>
            <input type="password" id="password" required>

            <input type="submit">
        </form>
    </body>
</html>

<!-- 
    REGISTRAZIONE
        Nome
        Cognome
        Email
        Username
        Pwd
-->