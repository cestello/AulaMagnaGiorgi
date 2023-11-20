<!DOCTYPE html>
<html>
    <head>

    </head>

    <body>
        <?php
            include('./utils.php');

            if ($_SERVER["REQUEST_METHOD"] == "POST")
            {
                $nome = $_POST["nome"];
                $cognome = $_POST["cognome"];
                $email = $_POST["email"];
                $password = $_POST["password"];

                if (!is_used($email))
                {
                    $status_code = is_valid($password);
                    if ($status_code == 0)
                    {
                        // TODO: manda al database
                        // TODO: redirect al login
                    }
                    else if ($status_code == 1)
                    {
                        echo("La lunghezza deve essere tra 8 e 32 caratteri");
                    }
                    else if ($status_code == 2)
                    {
                        echo("Parametri non rispettati: maiuscola, minuscola, numeri, carattere speciale");
                    }
                }
                else
                {
                    echo("Email gi&agrave; utilizzata");
                }
            }
        ?>

        <form action="./signin.php" method="post">
            <input type="text" id="nome" required>
            <input type="text" id="cognome" required>
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
        Pwd
-->