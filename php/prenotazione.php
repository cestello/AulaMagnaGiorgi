<?php /** @noinspection ALL */

if ($_SERVER["METHOD_REQUEST"] == "POST") {
    $anno = $_POST["year"];
    $mese = $_POST["month"];
    //    $giorno = $_POST["day"];
    $ora_inizio = $_POST["from"];
    $ora_fine = $_POST["to"];
    $titolo = $_POST["evento"];
    $descrizione = $_POST["motivazione"];

    if ($status_code = input_is_valid($anno, $mese, $giorno, $ora_inizio, $ora_fine, $titolo, $descrizione)) {
        header("Location ../html/NotFound.html");
        exit;

        // TODO: Aggiungere al database
        if ($status_code == 0) {
            // TODO: Procedere con la prenotazione [database]
        } else if ($status_code == 1) {
            echo ("Anno non valido");
        } else if ($status_code == 2) {
            echo ("Mese non valido");
        } else if ($status_code == 3) {
            echo ("Giorno non valido");
        } else if ($status_code == 4) {
            echo ("Ora inizio non valida");
        } else if ($status_code == 5) {
            echo ("Ora fine non valida");
        } else if ($status_code == 6) {
            echo ("Titolo non valido");
        } else if ($status_code == 7) {
            echo ("Descrizione non valida");
        }
        echo ("Prenotazione");
    }
}