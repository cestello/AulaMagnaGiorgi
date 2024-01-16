<?php
session_abort();
session_start();
include("./src/utils.php");
include("./src/check_cookie.php");
$is_logged_in = check();
$is_admin = false;
if ($is_logged_in) {
    $is_admin = check_admin();
}
?>
<!DOCTYPE html>
<html lang="it-IT">

<head>
    <link rel="stylesheet" href="./public/css/index.css">
    <title>
        Index
    </title>
</head>

<body>
    <div id="paper-back">
        <nav>
            <div class="close"></div> <a href="./index.php">Home</a>
            <a href="./public/calendario.php">Calendario</a>
            <?php
            if ($is_logged_in) {
                if ($is_admin) {
                    echo ("<a href=\"./public/prenotazioni_admin.php\">Prenotazioni <br>Admin</a>");
                }
                echo ("<a href=\"./public/prenotazione.php\">Prenota</a>");
                echo ("<a href=\"./public/profilo.php\">Profilo</a>");
                echo ("<a href=\"./src/logout.php\">Esci</a>");
            } else {
                echo ("<a href=\"./public/login.php\">Accedi</a>");
                echo ("<a href=\"./public/registrazione.php\">Registrati</a>");
            }
            ?>
        </nav>
    </div>
    <div id="paper-window">
        <div id="paper-front">
            <div class="hamburger"><span></span></div>
            <div id="sectionFormat">
                <h1>Aula Magna</h1>
                <section>
                    <div>
                        <a target="_blank" href="./resources/mosaico.gif" class="image">
                            <img src="./resources/mosaico.gif" alt="Mosaico" width="800" height="200">
                        </a>
                    </div>
                    <div>
                        <h1>
                            Particolare del mosaico dell'Aula Magna dell'I.T.T. "G. Giorgi"
                            Dal 1975, l'Aula Magna dell'istituto ospita una pregiata opera d'arte, "Il mosaico del
                            Progresso Scientifico e l'Uomo", fortemente significativa, ideata e progettata da Roberto
                            Manni, eccellente artista salentino (1912-2003).
                            L'opera fu eseguita da maestri musivi veneziani.
                        </h1>
                    </div>
                </section>
            </div>
        </div>
        <!-- JAVASCRIPT -->
        <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script id="rendered-js">
            let paperMenu = {
                $window: $('#paper-window'),
                $paperFront: $('#paper-front'),
                $hamburger: $('.hamburger'),
                offset: 1800,
                pageHeight: $('#paper-front').outerHeight(),

                open: function () {
                    this.$window.addClass('tilt');
                    this.$hamburger.off('click');
                    $('#container, .hamburger').on('click', this.close.bind(this));
                    this.hamburgerFix(true);
                },
                close: function () {
                    this.$window.removeClass('tilt');
                    $('#container, .hamburger').off('click');
                    this.$hamburger.on('click', this.open.bind(this));
                    this.hamburgerFix(false);
                },
                updateTransformOrigin: function () {
                    let scrollTop = this.$window.scrollTop();
                    let equation = (scrollTop + this.offset) / this.pageHeight * 100;
                    this.$paperFront.css('transform-origin', 'center ' + equation + '%');
                },
                //hamburger icon fix to keep its position
                hamburgerFix: function (opening) {
                    if (opening) {
                        $('.hamburger').css({
                            position: 'absolute',
                            top: this.$window.scrollTop() + 30 + 'px'
                        });
                    } else {
                        setTimeout(function () {
                            $('.hamburger').css({
                                position: 'fixed',
                                top: '30px'
                            });
                        }, 300);
                    }
                },
                bindEvents: function () {
                    this.$hamburger.on('click', this.open.bind(this));
                    $('.close').on('click', this.close.bind(this));
                    this.$window.on('scroll', this.updateTransformOrigin.bind(this));
                },
                init: function () {
                    this.bindEvents();
                    this.updateTransformOrigin();
                },
            };

            paperMenu.init();
        </script>
    </div>
</body>

</html>