<?php
session_abort();
session_start();

include_once "./src/utils.php";
include_once "./src/check_cookie.php";

$loggato = controllaSeLoggato();
$admin = false;
if ($loggato) {
    $admin = controllaSeAdmin();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/css/index.css" type="text/css">
	<!-- css nella stessa cartella worka, perche'? boh, lasciatelo qui al momento !-->
		<!-- modificato da napolitano, da provare -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Aula Magna</title>
</head>
<body>
    <div class="pre-header-container">
        <header class="pre-header">
            <h5>Sito dell'Aula Magna</h5>
            <nav class="nav-bar-pre-header">
                <?php
                if($loggato) {
                    echo '<a href="' . generaLinkRisorsa("public/profilo.php") . '" class="user-link"><img  src="resources/index/login.png" class="user-icon"></a>';
                    echo '<a href="' . generaLinkRisorsa("src/logout.php") . '" class="user-link"><img src="resources/index/uscita.png" class="user-icon"></a>';
                } else {
                    echo '<a href="' . generaLinkRisorsa("public/login.php") . '" class="user-link"><img src="resources/index/login.png" class="user-icon"></a>';
                }
                ?>
                
            </nav>
        </header>
    </div>
    
    <div class="header-container">
        <header class="header">
            <img src="resources/LogoGiorgi.png" alt=""><a href="#" class="logo"></a></img>
            <nav class="nav-bar">
                <?php
                if ($loggato) {
                    if ($admin) {
                        echo '<a href="' . generaLinkRisorsa("public/prenotazioni_admin.php?ID=type-nonvisionati");
                        echo '">Prenotazioni Admin</a>';
                    }
                    echo '<a href="' . generaLinkRisorsa("public/prenotazione.php") . '">Prenota</a>';
                }
                echo '<a href="' . generaLinkRisorsa("public/calendario.php") . '">Calendario</a>';
                ?>
            </nav>
            <div class="menu-toggle" onclick="toggleMobileMenu()">
                <i class="fas fa-bars"></i>
            </div>
        </header>
        <div class="mobile-menu" id="mobileMenu">
            <?php
            if ($loggato) {
                if ($admin) {
                    echo '<a href="' . generaLinkRisorsa("public/prenotazioni_admin.php?ID=type-nonvisionati");
                    echo '">Prenotazioni <br>Admin</a>';
                }
                echo '<a href="' . generaLinkRisorsa("public/prenotazione.php") . '">Prenota</a>';
                echo '<a href="' . generaLinkRisorsa("public/profilo.php") . '">Profilo</a>';
                echo '<a href="' . generaLinkRisorsa("src/logout.php") . '">Esci</a>';
            } else {
                echo '<a href="' . generaLinkRisorsa("public/login.php") . '">Accedi</a>';
                echo '<a href="' . generaLinkRisorsa("public/registrazione.php") . '">Registrati</a>';
            }
            ?>
        </div>
    </div>
   
    
    <!-- <caurosel> -->
    <div class="slideshow-container">

        <div class="mySlides fade">
            <img src="resources/index/rsz_minimalist.jpg" style="width:100%">
            <div class="text">Caption Text</div>
        </div>
    
        <div class="mySlides fade">
            <img src="resources/index/pexels-aleksandar-pasaric-325185.jpg" style="width:100%">
            <div class="text">Caption Two</div>
        </div>
    
        <div class="mySlides fade">
            <img src="resources/index/pexels-bess-hamiti-36487.jpg" style="width:100%">
            <div class="text">Caption Three</div>
        </div>

        <div class="mySlides fade">
            <img src="resources/index/pexels-james-wheeler-417074.jpg" style="width:100%">
            <div class="text">Caption four</div>
        </div>
    
        <a class="prev" onclick="plusSlides(-1)">❮</a>
        <a class="next" onclick="plusSlides(1)">❯</a>
    
    </div>
    <br>
    
    <div style="text-align:center">
        <span class="dot" onclick="currentSlide(1)"></span> 
        <span class="dot" onclick="currentSlide(2)"></span> 
        <span class="dot" onclick="currentSlide(3)"></span> 
        <span class="dot" onclick="currentSlide(4)"></span> 
    </div>

    <!-- <script> -->
    <script>
    let slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
    showSlides(slideIndex += n);
    }

    function currentSlide(n) {
    showSlides(slideIndex = n);
    }

    function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");
    if (n > slides.length) {slideIndex = 1}    
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";  
    dots[slideIndex-1].className += " active"; 
    }

    // Dichiarazione delle variabili globali per tenere traccia dell'indice della slide corrente

let startX; // Posizione iniziale del tocco

// Funzione per gestire l'evento di tocco iniziale
function handleTouchStart(event) {
  startX = event.touches[0].clientX; // Memorizza la posizione iniziale del tocco
}

// Funzione per gestire l'evento di tocco finale e determinare se deve essere effettuato uno swipe sinistro o destro
function handleTouchEnd(event) {
  let endX = event.changedTouches[0].clientX; // Posizione finale del tocco
  let deltaX = startX - endX; // Distanza percorsa dal tocco

  // Se la distanza percorsa è maggiore di un certo valore (ad esempio 50 pixel), considera il tocco come uno swipe
  if (Math.abs(deltaX) > 50) {
    if (deltaX > 0) {
      // Swipe sinistro: vai alla slide successiva
      plusSlides(1);
    } else {
      // Swipe destro: vai alla slide precedente
      plusSlides(-1);
    }
  }
}

// Aggiungi gli eventi touchstart e touchend all'elemento slideshow-container
document.querySelector('.slideshow-container').addEventListener('touchstart', handleTouchStart);
document.querySelector('.slideshow-container').addEventListener('touchend', handleTouchEnd);
    

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