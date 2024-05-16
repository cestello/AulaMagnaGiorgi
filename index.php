<?php
session_abort();
session_start();

include_once "./src/utils.php";
include_once "./src/check_cookie.php";

controllaSeLoggato();

?>

<!-- //TODO: header fixed
             titoli ai paragrafi
             vedere perche il css non va da file esterno
             rivedere il footer
             colori sfondo -->

<!DOCTYPE html>
<html lang="it-IT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <?php
    echo collegaCSS("index");
    ?>

    <title>
        Aula Magna
    </title>
</head>

<body>
    <?php include_once "./public/header.php"; ?>

    <!-- carosello -->
    <div class="carousel-conteiner">
        <div class="center">
            <div class="carousel">
                <div class="left">
                    <div class="left-item">
                        <div class="title">Tra il Mito e la Caccia</div> <br>
                        <div class="text-carousel">
                            "Nella porzione superiore del mosaico emerge la scena iconica del mito di Dedalo e Icaro,
                            con Icaro che precipita dopo essersi avvicinato troppo al sole, simboleggiando il fallimento
                            umano nell'ambizione eccessiva. Questo episodio rappresenta il nucleo narrativo del mosaico,
                            intitolato 'L&apos;Uomo e lo Sviluppo della Scienza'. Nella sezione inferiore, si individua un
                            affresco che richiama le pitture rupestri, ritraendo una tribù armata di archi in un'azione
                            di caccia. Questa combinazione di elementi offre una rappresentazione simbolica della
                            trasformazione umana nel contesto dell'evoluzione scientifica."
                        </div>
                    </div>

                    <div class="left-item">
                        <div class="title">L'Uso Animale e la Saggezza Antica</div>
                        <br>
                        <div class="text-carousel">
                            "In questa parte del mosaico, continua il progresso dell'umanità attraverso elementi
                            distintivi. Innanzitutto, si osserva l'uomo nell'atto di domare il cavallo, segnando un
                            momento cruciale in cui l'essere umano inizia a cambiare la propria vita
                            da nomade a sedentario, che assume un ruolo fondamentale per lo sviluppo dell'agricoltura.
                            Appena in alto, emerge la maestosità di un tempio greco, simbolo tangibile dell'evoluzione
                            dell'architettura e della civiltà. Nell'apice del mosaico, si distingue un ulivo,
                            icona di rigenerazione, aggiungendo una nota di speranza anche se, nel modo in cui &egrave;
                            stata rappresentata, dimostra ben altro."

                        </div>
                    </div>

                    <div class="left-item">
                        <div class="title">Difese e Cristianesimo</div><br>
                        <div class="text-carousel">
                            "In questa sezione del mosaico, viene rappresentato il processo di urbanizzazione umana
                            attraverso la costruzione di castelli, concepiti come fortezze difensive contro le
                            incursioni dei Saraceni che, navigando nel Mar Tirreno, minacciavano le città italiane con
                            atti di saccheggio. Si osserva la presenza di una croce, simbolo emblematico del
                            cristianesimo, nato nel primo secolo dopo Cristo. Questi elementi delineano il contesto
                            storico e culturale dell'epoca, con l'urbanizzazione che si accompagna alla diffusione del
                            cristianesimo nella società medievale."
                        </div>
                    </div>

                    <div class="left-item">
                        <div class="title">Rinascimento Intellettuale</div><br>
                        <div class="text-carousel">
                            "In questa parte del mosaico, ci troviamo tra il XV e il XVI secolo, un periodo di notevole
                            avanzamento nelle discipline della medicina, dell'astronomia e della geometria, con Leonardo
                            da Vinci in primo piano. Si evidenzia l'introduzione della prospettiva aerea, attribuita a
                            Leonardo, che rivoluzionò l'arte e la rappresentazione visiva. Si osserva il serpente,
                            simbolo dell'utilizzo del veleno nella preparazione di medicine, a indicare i progressi
                            nella scienza medica. In alto, è raffigurato il teorema di Keplero, formulato dallo
                            scienziato Johannes Kepler, che enunciò le tre leggi del moto planetario, confermando il
                            modello eliocentrico del sistema solare. Questi elementi testimoniano il fervore
                            intellettuale e scientifico del Rinascimento, con figure come Leonardo e Keplero che
                            lasciarono un'impronta indelebile nello sviluppo del sapere umano."
                        </div>
                    </div>

                    <div class="left-item">
                        <div class="title">La Prima Rivoluzione Industriale: Cambio Epocale</div><br>
                        <div class="text-carousel">
                            "In questa fase rappresentata nel mosaico, ci immergiamo nell'epoca della prima rivoluzione
                            industriale, caratterizzata dall'invenzione della macchina rotativa a vapore e
                            dall'espansione delle ferrovie grazie all'introduzione delle rotaie, determinando un
                            notevole impulso allo sviluppo di nuove tecnologie tessili e metallurgiche. Da menzionare è
                            anche la fondamentale invenzione dell'alambicco nel campo della chimica, insieme alla
                            scoperta dell'atomo e alla formulazione delle prime teorie sperimentali sulla natura della
                            materia. Questi progressi indicano un periodo di significativo cambiamento e avanzamento
                            tecnologico, che avrebbe lasciato un'impronta indelebile sulle società e sull'economia del
                            tempo."
                        </div>
                    </div>

                    <div class="left-item">
                        <div class="title">Progresso Tecnologico e Sfide Umane</div><br>
                        <div class="text-carousel">
                            "Nella sezione del mosaico ci troviamo all'inizio della seconda rivoluzione industriale, si
                            evidenziano due elementi emblematici: l'invenzione del razzo e la proliferazione dei
                            grattacieli. Questi simboli incarnano il progresso nell'esplorazione spaziale e l'accelerata
                            urbanizzazione delle metropoli. Al di sotto, le espressioni di tristezza e trasfigurazione
                            sui volti umani sottolinea le sfide sociali e umane correlate alla rapida avanzata
                            scientifica. Questa sezione del mosaico mira a una riflessione sulle intricate connessioni
                            tra lo sviluppo tecnologico e le sue conseguenze socio-culturali, sottolineando l'urgenza di
                            affrontare con serietà le implicazioni etiche e sociali di tali progressi."
                        </div>
                    </div>

                    <div class="left-item">
                        <div class="title">Industrializzazione e <br>Mostri</div><br>
                        <div class="text-carousel">
                            "Nella sezione finale del mosaico, ci immergiamo nel periodo dell'industrializzazione con la
                            proliferazione delle fabbriche, elemento chiave che segna la diffusione dell'inquinamento
                            globale. Oltre alle fabbriche, emergono figure mostruose che simboleggiano l'uomo e la sua
                            malvagità nei confronti del pianeta madre che lo ha nutrito, mentre egli lo avvelena e lo
                            distrugge. Questa rappresentazione drammatica intende evidenziare le conseguenze devastanti
                            dell'industrializzazione senza controllo sull'ambiente e sottolineare l'urgente necessità di
                            adottare pratiche più sostenibili e rispettose dell'ecosistema."
                        </div>
                    </div>


                </div>
                <div class="right">
                    <div class="item active">
                        <img src="resources/webp/DJI_0572.webp" alt="">
                    </div>

                    <div class="item">
                        <img src="resources/webp/DJI_0573.webp" alt="" />
                    </div>

                    <div class="item">
                        <img src="resources/webp/DJI_0576.webp" alt="" />
                    </div>

                    <div class="item">
                        <img src="resources/webp/DJI_0575.webp" alt="" />
                    </div>

                    <div class="item">
                        <img src="resources/webp/DJI_0577.webp" alt="" />
                    </div>

                    <div class="item">
                        <img src="resources/webp/DJI_0578.webp" alt="" />
                    </div>

                    <div class="item">
                        <img src="resources/webp/DJI_0580.webp" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once "./public/footer.php"; ?>

    <script>
        let items = document.querySelectorAll(".item");
        let carousel = document.querySelector(".carousel");
        document.addEventListener("scroll", () => {
            let proportion =
                carousel.getBoundingClientRect().top / window.innerHeight;
            let index = Math.ceil(-1 * (proportion + 0.5));
            items.forEach((item, i) => {
                item.className = "item";
                if (i == index) {
                    item.className = "item active";
                }
            });
        });


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

        // Caricamento asincrono delle immagini del mosaico
        function scaricaImmagini(url) {
            return new Promise((resolve, reject) => {
                const image = new Image();
                image.onload = () => resolve(url);
                image.onerror = () => reject(new Error(`Caricamento dell'immagine fallito: ${url}`));
                image.src = url;
            });
        }

        // async function precaricamentoImmagini(immagini) {
        //     try {
        //         const promises = immagini.map(url => scaricaImmagini(url));
        //         await Promise.all(promises);
        //         // console.log("Immagini caricate correttamente");
        //     } catch (error) {
        //         console.error("Errore durante il caricamento delle immagini: ", error);
        //     }
        // }

        async function precaricamentoImmagini(imageUrls) {
            try {
                for (let i = 0; i < imageUrls.length; i++) {
                    await scaricaImmagini(imageUrls[i]);
                    // console.log(`Image ${imageUrls[i]} preloaded successfully!`);
                }
            } catch (error) {
                console.error("Errore nel precaricamento delle immagini:", error);
            }
        }

        function caricaImmagini() {
            // Array di URL delle immagini da scaricare
            const immagini = [
                "resources/webp/DJI_0572.webp",
                "resources/webp/DJI_0573.webp",
                "resources/webp/DJI_0576.webp",
                "resources/webp/DJI_0575.webp",
                "resources/webp/DJI_0577.webp",
                "resources/webp/DJI_0578.webp",
                "resources/webp/DJI_0580.webp"
            ];

            precaricamentoImmagini(immagini);
        }

        caricaImmagini();
    </script>
</body>

</html>
