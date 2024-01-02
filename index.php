<!DOCTYPE html>
<html lang="it-IT">

<head>
    <link rel="stylesheet" href="./css/index.css">
    <title>
        Index
    </title>
</head>

<body>
    <div id="paper-back">
        <nav>
            <div class="close"></div>
            <a href="#">Home</a>
            <a href="./html/calendario.html">Calendario</a>
            <?php
            include('./util/utils.php');
            include("./php/check_cookie.php");
            if (!check()) {
                echo("<a href='./html/login.php'>Log In</a>");
            } else {
                echo("<a href='./php/logout.php'>Log Out</a>");
            }
            echo($_SESSION['message']);
            ?>
        </nav>
    </div>
    <div id="paper-window">
        <div class="login"><span>
                <a href="./html/login.php" class="login">
                    <img src="./img/LogoGiorgi.png" alt="Login" width="45" height="34">
                </a>
            </span></div>
        <div id="paper-front">
            <div class="hamburger"><span></span></div>
            <div id="sectionFormat">
                <h1>Aula Magna</h1>
                <section>
                    <div>
                        <a target="_blank" href="./gif/mosaico.gif" class="image">
                            <img src="./gif/mosaico.gif" alt="Mosaico" width="800" height="200">
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
                    console.log('opening...');
                },
                close: function () {
                    this.$window.removeClass('tilt');
                    $('#container, .hamburger').off('click');
                    this.$hamburger.on('click', this.open.bind(this));
                    this.hamburgerFix(false);
                    console.log('closing...');
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