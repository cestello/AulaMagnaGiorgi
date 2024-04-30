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
    <style>
            .slideshow-container {
                width: 500px; /* larghezza del contenitore */
                height: 600px; /* altezza del contenitore */
                overflow: hidden; /* per assicurarsi che l'immagine non sfori il contenitore */
            }

            .slideshow-container img {
                width: 100%; /* rende l'immagine larga quanto il contenitore */
                height: auto; /* mantiene l'aspetto proporzionato */
                display: block; /* assicura che l'immagine non abbia spazi vuoti intorno */
            }
</style>
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
            <img src="resources/index/DJI_0572.jpg" style="width:100%">
            <div class="text">"Nella porzione superiore del mosaico emerge la scena iconica del mito di Dedalo e Icaro, con Icaro che precipita dopo essersi avvicinato troppo al sole, simboleggiando il fallimento umano nell'ambizione eccessiva. Questo episodio rappresenta il nucleo narrativo del mosaico, intitolato 'Dallo Sviluppo della Scienza all'Uomo'.
Nella sezione inferiore, si individua un affresco che richiama le pitture rupestri, ritraendo una tribù armata di archi in un'azione di caccia. 
Questa combinazione di elementi offre una rappresentazione simbolica della trasformazione umana nel contesto dell'evoluzione scientifica e sociale."
            </div>
        </div>
    
        <div class="mySlides fade">
            <img src="resources/index/DJI_0573.jpg" style="width:100%">
            <div class="text">"In questa parte del mosaico, continua il progresso dell'umanità attraverso elementi distintivi. Innanzitutto, si osserva l'uomo nell'atto di addestrare il cavallo, segnando un momento cruciale in cui l'essere umano inizia a dominare gli animali per facilitare i propri spostamenti, con il cavallo che assume un ruolo fondamentale nei primi viaggi dell'uomo. In aggiunta, emerge la maestosità di un tempio greco, simbolo tangibile dell'evoluzione dell'architettura e della civiltà. Nell'apice dell'immagine, invece, si distingue un ulivo, icona di rigenerazione, vita e pace, aggiungendo una nota di speranza e tranquillità al quadro complessivo."
            </div>
        </div>

        <div class="mySlides fade">
            <img src="resources/index/DJI_0576.jpg" style="width:100%">
            <div class="text">"In questa sezione del mosaico, viene rappresentato il processo di urbanizzazione umana attraverso la costruzione di castelli, concepiti come fortezze difensive contro le incursioni dei Saraceni che, navigando nel Mar Tirreno, minacciavano le città italiane con atti di saccheggio. Si osserva la presenza di una croce, simbolo emblematico del cristianesimo, nato nel primo secolo dopo Cristo. Questi elementi delineano il contesto storico e culturale dell'epoca, con l'urbanizzazione che si accompagna alla diffusione del cristianesimo nella società medievale."
            </div>
        </div>

        <div class="mySlides fade">
            <img src="resources/index/DJI_0575.jpg" style="width:100%">
            <div class="text">"In questa parte del mosaico, ci troviamo tra il XV e il XVI secolo, un periodo di notevole avanzamento nelle discipline della medicina, dell'astronomia e della geometria, con Leonardo da Vinci in primo piano. Si evidenzia l'introduzione della prospettiva aerea, attribuita a Leonardo, che rivoluzionò l'arte e la rappresentazione visiva. Si osserva il serpente, simbolo dell'utilizzo del veleno nella preparazione di medicine, a indicare i progressi nella scienza medica. In alto, è raffigurato il teorema di Keplero, formulato dallo scienziato Johannes Kepler, che enunciò le tre leggi del moto planetario, confermando il modello eliocentrico del sistema solare. Questi elementi testimoniano il fervore intellettuale e scientifico del Rinascimento, con figure come Leonardo e Keplero che lasciarono un'impronta indelebile nello sviluppo del sapere umano."
            </div>   
        </div>

        <div class="mySlides fade">
            <img src="resources/index/DJI_0577.jpg" style="width:100%">
            <div class="text">"In questa fase rappresentata nel mosaico, ci immergiamo nell'epoca della prima rivoluzione industriale, caratterizzata dall'invenzione della macchina rotativa a vapore e dall'espansione delle ferrovie grazie all'introduzione delle rotaie, determinando un notevole impulso allo sviluppo di nuove tecnologie tessili e metallurgiche. Da menzionare è anche la fondamentale invenzione dell'alambicco nel campo della chimica, insieme alla scoperta dell'atomo e alla formulazione delle prime teorie sperimentali sulla natura della materia. Questi progressi indicano un periodo di significativo cambiamento e avanzamento tecnologico, che avrebbe lasciato un'impronta indelebile sulle società e sull'economia del tempo."
            </div>
        </div>

        <div class="mySlides fade">
            <img src="resources/index/DJI_0578.jpg" style="width:100%">
            <div class="text">"Nella sezione del mosaico ci troviamo all'inizio  della seconda rivoluzione industriale, si evidenziano due elementi emblematici: l'invenzione del razzo e la proliferazione dei grattacieli. Questi simboli incarnano il progresso nell'esplorazione spaziale e l'accelerata urbanizzazione delle metropoli. Al di sotto, le espressioni di tristezza e trasfigurazione sui volti umani sottolinea le sfide sociali e umane correlate alla rapida avanzata scientifica. Questa sezione del mosaico mira a una riflessione sulle intricate connessioni tra lo sviluppo tecnologico e le sue conseguenze socio-culturali, sottolineando l'urgenza di affrontare con serietà le implicazioni etiche e sociali di tali progressi."
            </div>
        </div>

        <div class="mySlides fade">
            <img src="resources/index/DJI_0580 (1).jpg" style="width:100%">
            <div class="text">"Nella sezione finale del mosaico, ci immergiamo nel periodo dell'industrializzazione con la proliferazione delle fabbriche, elemento chiave che segna la diffusione dell'inquinamento globale. Oltre alle fabbriche, emergono figure mostruose che simboleggiano l'uomo e la sua malvagità nei confronti del pianeta madre che lo ha nutrito, mentre egli lo avvelena e lo distrugge. Questa rappresentazione drammatica intende evidenziare le conseguenze devastanti dell'industrializzazione senza controllo sull'ambiente e sottolineare l'urgente necessità di adottare pratiche più sostenibili e rispettose dell'ecosistema."
            </div>
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
        <span class="dot" onclick="currentSlide(5)"></span>
        <span class="dot" onclick="currentSlide(6)"></span>
        <span class="dot" onclick="currentSlide(7)"></span> 
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


