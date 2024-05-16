<?php

session_abort();
session_start();

include_once "../src/utils.php";
include_once "../src/check_cookie.php";

// Se l'utente è già loggato, viene reindirizzato all'index
if (controllaSeLoggato()) {
    header("Location: " . generaLinkRisorsa("public/profilo.php"));
    die();
}

include_once "../src/login.php";

?>

<!DOCTYPE html>
<html lang="it-IT">

<head>
    <?php
    echo collegaCSS("style");
    ?>

    <title>Login</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Titillium Web, sans-serif;
        }

        #form-container {
            margin: 0 auto;
            margin-top: 200px;
            max-width: 400px;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 10px;
        }

        #formLogin h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        #formLogin label {
            display: block;
            margin-bottom: 5px;
        }

        #formLogin input[type="text"],
        #formLogin input[type="password"] {
            width: calc(100% - 10px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #formLogin input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            background-color: #51758d;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        #formLogin input[type="submit"]:hover {
            background-color: #43667e;
        }

        #formLogin a {
            display: block;
            text-align: center;
            margin-top: 10px;
            text-decoration: none;
            color: #51758d;
        }

        #formLogin a:hover {
            color: #43667e;
        }

        span {
            color: #ffffff;
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
            content: '';
            position: absolute;
            top: 100%;
            left: 0;
            width: 0;
            height: 2px;
            background: #000;
            transition: .3s;
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
            content: '';
            position: absolute;
            top: 100%;
            left: 0;
            width: 0;
            height: 2px;
            background: #000;
            transition: .3s;
        }

        .pre-header .nav-bar a::before {
            content: '';
            position: absolute;
            top: 100%;
            left: 0;
            width: 0;
            height: 2px;
            background: #ffffff;
            transition: .3s;
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

        /* stile per laptop dimensioni s*/
        @media only screen and (max-width: 1050px) {
            .header {
                padding: 3px 70px;
            }

            .pre-header {
                padding: 10px 70px;
            }

        }



        /* Stili per schermi di dimensioni massime (tablet) */
        @media only screen and (max-width: 890px) {
            .header {
                padding: 3px 30px;
            }

            .pre-header {
                padding: 10px 30px;
            }

            .nav-bar a {
                margin-left: 20px;
            }


            .nav-bar a {
                display: none;
            }

            .menu-toggle {
                display: inline-block;
                margin: 2px;
                display: inline-block;
                font-size: 45px;
                color: #333;
                cursor: pointer;
                transition: color 0.7s ease;
                transition: transform 0.5s ease;

            }




            .mobile-menu {
                position: relative;
                top: 100%;
                width: 100%;
                background-color: #51758d;
                margin-bottom: 10px;
                overflow-y: auto;
            }

            .mobile-menu a {
                font-size: 18px;
                display: block;
                font-weight: normal;
                padding: 12px;
                margin: 2px;
                text-align: center;
                text-decoration: none;
                border: solid;
                color: #ffffff;
                overflow: scroll;
            }


            .mobile-menu a:hover {
                background-color: #43667e;
            }
        }

        @media only screen and (max-width: 479px) {}

        /* Stili per schermi di piccole dimensioni (smartphone) */
        @media only screen and (max-width: 479px) {
            .header {
                padding: 3px 20px;
            }

            .pre-header {
                padding: 10px 20px;
            }

            .nav-bar {
                flex-direction: column;
                align-items: center;
            }

            .nav-bar a {
                padding: 8px;
            }

            .nav-bar-pre-header {
                flex-direction: column;
                align-items: center;
            }


            .nav-bar-pre-header a {
                padding: 2px;
                margin-left: 20px;
            }



            .nav-bar a {
                display: none;
            }

            .menu-toggle {
                display: inline-block;
                margin: 2px;
                display: inline-block;
                font-size: 45px;
                color: #333;
                cursor: pointer;
                transition: color 0.7s ease;
                transition: transform 0.5s ease;

            }




            .mobile-menu {
                position: relative;
                top: 100%;
                width: 100%;
                background-color: #51758d;
                margin-bottom: 10px;
            }

            .mobile-menu a {
                font-size: 18px;
                display: block;
                font-weight: normal;
                padding: 12px;
                margin: 2px;
                text-align: center;
                text-decoration: none;
                border: solid;
                color: #ffffff;

            }


            .mobile-menu a:hover {
                background-color: #43667e;
            }

        }
    </style>
</head>

<body>
    <?php include_once "./header.php"; ?>

    <div id="form-container">
        <form method="post" id="formLogin">
            <?php
            echo '<a href="' . generaLinkRisorsa() . '">';
            ?>
            </a>
            <h1>Login</h1><br>

            <label for="username">Email: </label>
            <input type="text" id="username" name="username" minlength="7" maxlength="128" required><br><br>

            <label for="password">Password: </label>
            <input type="password" id="password" name="password" minlength="8" maxlength="64" required>
            <br>

            <?php
            echo '<a href="' . generaLinkRisorsa("public/registrazione.php") . '">Non hai un account? Registrati</a>';
            ?>
            <br><br>

            <div id="submit">
                <input type="submit" value="Accedi">
                <span>
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                    }
                    unset($_SESSION['message']);
                    ?>
                </span>
            </div>
        </form>
    </div>

    <?php include_once "./footer.php"; ?>

    <script src="https://kit.fontawesome.com/a8d5f6e743.js" crossorigin="anonymous"></script>
    <script>
        function toggleMobileMenu() {
            var mobileMenu = document.getElementById("mobileMenu");
            var menuToggle = document.querySelector(".menu-toggle");

            if (mobileMenu.style.display === "block") {
                mobileMenu.style.display = "none";
                menuToggle.innerHTML = '<i class="fas fa-bars"></i>'; // Ripristina l'icona del menu
                menuToggle.style.transform = "rotate(0deg)";
            } else {
                mobileMenu.style.display = "block";
                menuToggle.innerHTML = '<i class="fas fa-times"></i>'; // Mostra la "x" per chiudere il menu
                menuToggle.style.transform = "rotate(90deg)";
            }
        }
    </script>
</body>

</html>
